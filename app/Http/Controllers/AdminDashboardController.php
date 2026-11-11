<?php

namespace App\Http\Controllers;

use App\Helpers\StoreImage;
use App\Models\ReferenceCategory;
use App\Models\HelpAbout;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{
	public function index()
	{
		$categories = ReferenceCategory::with('refCategoryRelationWith_pages')->get();
		return view('backend.layouts.reference.index', compact('categories'));
	}

	public function allUsers()
	{
		// dd("adasfs");
		return view('backend.layouts.admin.users');
	}

	public function aboutHelpIndex()
	{
		$data = HelpAbout::all();
		$help_about_us = $data->where('type', 'help_about_us')->first();
		return view('backend.layouts.admin.about_help', compact('help_about_us'));
	}

	public function helpAboutStore(Request $request)
	{
		// dd($request->all());
		try {
			// Validation
			$validator = Validator::make($request->all(), [
				'type' => 'required|string',
				'about_us' => ['nullable', 'string', 'max:2000'],
				'help' => ['nullable', 'string', 'max:2000'],
				'terms' => ['nullable', 'string', 'max:2000'],
				'privacy' => ['nullable', 'string', 'max:2000'],
			]);


			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			// Either update existing record or create new one
			$storeData = HelpAbout::updateOrCreate(
				['type' => $request->type],
				[
					'about_us' => $request->about_us ?? null,
					'help' => $request->help ?? null,
					'terms' => $request->terms ?? null,
					'privacy' => $request->privacy ?? null,
				]
			);

			return redirect()->route('manage.about_help')
				->with('success', ucfirst($request->type) . " content updated successfully!");

		} catch (\Exception $e) {
			return back()->with('error', 'Something went wrong: ' . $e->getMessage());
		}
	}

	// ---------------------------------------------
	public function all_users_data(Request $request)
	{
		try {
			// Define columns that can be ordered
			$columns = ['id', 'avatar', 'name', 'email', 'role', 'status', 'phone', 'created_at'];

			$draw = intval($request->input('draw'));
			$start = intval($request->input('start', 0));
			$length = intval($request->input('length', 25));
			$orderColIndex = intval($request->input('order.0.column', 0));
			$orderCol = $columns[$orderColIndex] ?? 'id';
			$orderDir = $request->input('order.0.dir', 'asc');

			// Base query
			$query = User::query();

			// Get total records before filtering
			$recordsTotal = $query->count();

			// Apply search filter
			if ($search = $request->input('search.value')) {
				$query->where(function ($q) use ($search) {
					$q->where('name', 'like', "%{$search}%")
						->orWhere('email', 'like', "%{$search}%")
						->orWhere('role', 'like', "%{$search}%")
						->orWhere('status', 'like', "%{$search}%");
				});
			}

			// Get filtered count
			$recordsFiltered = $query->count();

			// Get paginated results
			$users = $query->orderBy($orderCol, $orderDir)
				->offset($start)
				->limit($length)
				->get()
				->map(function ($row, $index) use ($start) {

					return [
						'SN' => $start + $index + 1,
						'id' => $row->id,
						'avatar' => $row->avatar
							? '<img src="' . asset('storage/' . $row->avatar) . '" alt="Error" class="rounded-circle" width="60" height="60" style="object-fit: cover;">'
							: '<div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 60px; height: 60px; font-size: 14px;">' . strtoupper(substr($row->name ?: 'U', 0, 1)) . '</div>',
						'name' => $row->name ?: 'N/A',
						'email' => $row->email,
						'phone' => $row->phone,
						'address' => $row->address,
						'bio' => $row->bio,
						'password' => '<span class="badge bg-secondary">Protected</span>', // Don't show actual passwords
						'created_at' => $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : 'N/A',
						'actions' => '
                        <div class="btn-group" role="group">
                            <form method="POST" action="' . route('backend.user_delete', $row->id) . '" style="display: inline-block;" onsubmit="return confirm(\'Are you sure you want to delete this user?\')">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    '
					];
				})
				->toArray();

			return response()->json([
				'draw' => $draw,
				'recordsTotal' => $recordsTotal,
				'recordsFiltered' => $recordsFiltered,
				'data' => $users,
			]);

		} catch (\Exception $e) {
			\Log::error('DataTable Error: ' . $e->getMessage());

			return response()->json([
				'draw' => intval($request->input('draw')),
				'recordsTotal' => 0,
				'recordsFiltered' => 0,
				'data' => [],
				'error' => 'An error occurred while fetching data.'
			], 500);
		}
	}

	public function userDelete(User $id)
	{
		$name = '';
		try {
			$name = $id->name;

			// Delete avatar file if exists
			if ($id->avatar) {
				if (\Storage::disk('public')->exists($id->avatar)) {
					\Storage::disk('public')->delete($id->avatar);
					\Log::info("Deleted avatar file: {$id->avatar} for user: {$name}");
				} else {
					\Log::warning("Avatar file not found: {$id->avatar} for user: {$name}");
				}
			}

			// Delete the user record
			$id->delete();

			return back()->with("success", "The user {$name} and their avatar have been deleted successfully");

		} catch (\Exception $e) {
			\Log::error("User deletion failed for {$name}. Error: " . $e->getMessage());
			return back()->with("error", "The user deletion of {$name} has failed! Try again. Reason: " . $e->getMessage());
		}
	}

	// ---------------------------------------------

	public function thisAdminProfile()
	{
		try {
			$userData = Auth::user();

			return view('backend.layouts.admin.profile', compact('userData'));

		} catch (\Exception $e) {
			return view('backend.layouts.admin.profile')->with('error', "Error performing this action: " . $e->getMessage());
		}
	}

	public function thisAdminProfileUpdate(Request $request, $id)
	{
		try {
			$user = User::findOrFail($id);

			$validator = Validator::make($request->all(), [
				'name' => ['required', 'string', 'max:200'],
				'email' => 'required|email|max:255|unique:users,email,' . $id,
				'phone' => ['nullable', 'string', 'max:20'],
				'address' => ['nullable', 'string', 'max:500'],
				'avatar' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
				'remove_avatar' => ['nullable', 'in:0,1'],
				'password' => ['nullable', 'string', 'min:6', 'confirmed'], // password confirmation
			]);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$validated = $validator->validated();

			// Update basic fields
			$user->update([
				'name' => $validated['name'],
				'email' => $validated['email'],
				'phone' => $validated['phone'] ?? null,
				'address' => $validated['address'] ?? null,
			]);

			// ------------ Password Update ------------
			if (!empty($validated['password'])) {
				$user->password = Hash::make($validated['password']);
			}

			// ------------ Avatar Handling ------------
			// Remove avatar if requested
			if (!empty($validated['remove_avatar']) && $validated['remove_avatar'] == 1) {
				if ($user->avatar && $user->avatar !== 'no-content') {
					Storage::disk('public')->delete($user->avatar);
				}
				$user->avatar = null;
			}

			// Upload new avatar
			if ($request->hasFile('avatar')) {
				if ($user->avatar && $user->avatar !== 'no-content') {
					Storage::disk('public')->delete($user->avatar);
				}
				$uploadedFile = $request->file('avatar');
				$path = StoreImage::storeFile($uploadedFile, $validated['name'], 'admin-avatar', 'public');
				$user->avatar = $path;
			}

			$user->save();

			return redirect()->back()->with('success', 'Profile updated successfully.');

		} catch (QueryException $e) {
			\Log::error('Database error in thisAdminProfileUpdate: ' . $e->getMessage());
			return redirect()->back()->withErrors(['error' => 'Database error occurred'])->withInput();
		} catch (\Exception $e) {
			\Log::error('Error in thisAdminProfileUpdate: ' . $e->getMessage());
			return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])->withInput();
		}
	}


	// -------------------PUBLIC DISPLAY--------------------------
	public function publicDisplayAbout()
	{
		$publicData = HelpAbout::where('type', 'help_about_us')->first();

		return view('publishable.about-us', compact('publicData'));
	}
	
	public function publicDisplayTerms()
	{
		$publicData = HelpAbout::where('type', 'help_about_us')->first();

		return view('publishable.terms', compact('publicData'));
	}
	
	public function publicDisplayPrivacy()
	{
		$publicData = HelpAbout::where('type', 'help_about_us')->first();

		return view('publishable.privacy', compact('publicData'));
	}

}
