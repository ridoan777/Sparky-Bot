<?php

namespace App\Http\Controllers\API;


use App\Helpers\ImageManagement;
use App\Models\HelpAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
	public function index()
	{
		try {
			$userData = Auth::user();

			return response()->json([
				'status' => 200,
				'message' => 'This users data has been successfully retrieved!',
				'data' => $userData
			]);

		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		}
	}

	public function update(Request $request)
	{
		try {
			$user = Auth::user();

			// Validation rules
			$rules = [
				'name' => 'nullable|string|max:255',
				'email' => 'nullable|email',
				'password' => 'nullable|string|min:8',
				'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				'phone' => 'nullable|string|max:255',
				'address' => 'nullable|string|max:255',
				'bio' => 'nullable|string', // no fixed limit; DB uses text
				'latitude' => 'nullable|numeric',
				'longitude' => 'nullable|numeric',
			];

			$validated = $request->validate($rules);

			// Check if user is trying to change email
			$newEmail = $validated['email'] ?? null;
			$isEmailChanging = $newEmail && $newEmail !== $user->email;

			// If email is changing, ensure uniqueness across email and pending_email
			if ($isEmailChanging) {
				$exists = User::where(function ($q) use ($newEmail, $user) {
					$q->where('email', $newEmail)
						->orWhere('pending_email', $newEmail);
				})->where('id', '!=', $user->id)->exists();

				if ($exists) {
					return response()->json([
						'status' => 422,
						'message' => 'The provided email is already in use.',
						'errors' => ['email' => ['The provided email is already in use.']]
					], 422);
				}
			}

			// ----------- Image handling -----------
			if ($request->hasFile('avatar_file') || $request->hasFile('avatar')) {
				$avatarFile = $request->file('avatar_file') ?? $request->file('avatar');

				// Delete old avatar if exists
				if ($user->avatar) {
					if (Storage::disk('public')->exists($user->avatar)) {
						Storage::disk('public')->delete($user->avatar);
					}
				}

				// Use first 10 characters of name or email for filename
				$title = substr($user->name ?: $user->email, 0, 10);

				// Store the new file
				$storedPath = ImageManagement::storeFile(
					$avatarFile,
					$title,       // filename prefix
					'user-avatar',
					'public'
				);

				// Save relative path in DB (no url('storage/...'))
				$validated['avatar'] = $storedPath;
			}
			// ----------- Image handling -----------



			// Remove email from validated data so it isn't prematurely saved
			if ($isEmailChanging) {
				unset($validated['email']);
			}

			DB::beginTransaction();

			// Hash password before saving
			if (!empty($validated['password'])) {
				$validated['password'] = Hash::make($validated['password']);
			}

			// Update other profile fields
			$user->fill($validated);
			$user->save();

			if ($isEmailChanging) {
				$otp = rand(1000, 9999);
				$user->pending_email = $newEmail;
				$user->otp = $otp;
				$user->otp_expiration = Carbon::now()->addMinutes(15);
				$user->save();

				// Send OTP to the new (pending) email
				Mail::send('emails.otp-reg', ['otp' => $otp], function ($message) use ($user) {
					$message->to($user->pending_email);
					$message->subject('Verify your new email');
				});

				DB::commit();

				// DO NOT return the OTP in response in production
				return response()->json([
					'status' => 200,
					'message' => 'Profile updated. An OTP has been sent to your new email. Verify to complete the email change.',
					'data' => $user, // user with pending_email set
					'email_pending' => true
				], 200);
			}

			DB::commit();

			return response()->json([
				'status' => 200,
				'message' => 'Profile updated successfully!',
				'data' => $user
			], 200);

		} catch (ValidationException $e) {
			// validation errors
			return response()->json([
				'status' => 422,
				'message' => 'Validation failed',
				'errors' => $e->errors()
			], 422);
		} catch (QueryException $e) {
			DB::rollBack();
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			], 500);
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			], 500);
		}
	}

	public function verifyEmailChange(Request $request)
	{
		try {
			$request->validate(['otp' => 'required|numeric']);
			$user = Auth::user();

			if (!$user->pending_email) {
				return response()->json([
					'status' => 400,
					'message' => 'No pending email change request found.'
				], 400);
			}

			if ($user->otp != $request->otp || Carbon::now()->greaterThan($user->otp_expiration)) {
				return response()->json([
					'status' => 400,
					'message' => 'Invalid or expired OTP.'
				], 400);
			}

			// Re-check uniqueness (race condition safety) - ensure no other account claimed it
			$exists = User::where(function ($q) use ($user) {
				$q->where('email', $user->pending_email)
					->orWhere('pending_email', $user->pending_email);
			})->where('id', '!=', $user->id)->exists();

			if ($exists) {
				return response()->json([
					'status' => 409,
					'message' => 'The new email is already taken by another account.'
				], 409);
			}

			DB::beginTransaction();

			// Commit the email change
			$user->email = $user->pending_email;
			$user->pending_email = null;
			$user->otp = null;
			$user->otp_expiration = null;
			$user->email_verified_at = Carbon::now();
			$user->save();

			DB::commit();

			return response()->json([
				'status' => 200,
				'message' => 'Email updated and verified successfully.',
				'data' => $user
			], 200);

		} catch (ValidationException $e) {
			return response()->json([
				'status' => 422,
				'message' => 'Validation failed',
				'errors' => $e->errors()
			], 422);
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			], 500);
		}
	}

	public function resendEmailChangeOtp()
	{
		try {
			$user = Auth::user();

			if (!$user->pending_email) {
				return response()->json([
					'status' => 400,
					'message' => 'No pending email change request.'
				], 400);
			}

			$otp = rand(1000, 9999);
			$user->otp = $otp;
			$user->otp_expiration = Carbon::now()->addMinutes(15);
			$user->save();

			Mail::send('emails.otp-reg', ['otp' => $otp], function ($message) use ($user) {
				$message->to($user->pending_email);
				$message->subject('Your email change OTP');
			});

			return response()->json([
				'status' => 200,
				'message' => 'A new OTP has been sent to your new email address.'
			], 200);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			], 500);
		}
	}

	// --------------------- API Calls --------------------------

	
	public function apiHelpAbout()
	{
		$data = HelpAbout::all();
		$help_about_us = $data->where('type', 'help_about_us')->first();

		if (!$help_about_us || !$help_about_us->help || !$help_about_us->about_us) {
			return response()->json([
				'status' => true,
				'message' => 'Content not found',
				'help_about_us' => null,
				'code' => 200
			]);
		}
		return response()->json([
			'status' => true,
			'help_about_us' => $help_about_us,
			'code' => 200
		]);
	}

	public function userDelete(Request $request)
	{
		$request->validate([
			// 'password' => 'required|string|min:8',
		]);

		$user = Auth::user();
		
		if (!$user || $user->role === 'admin' || $user->role === 'Admin') {
			return response()->json([
				'status' => 401,
				'message' => 'Unauthorized! The user does not exist or need a higher role to perform this action.'
			], 401);
		}

		// if (!Hash::check($request->password, $user->password)) {
		// 	return response()->json([
		// 		'status' => 401,
		// 		'message' => 'Password confirmation failed.'
		// 	], 401);
		// }

		try {
			DB::beginTransaction();

			$user->delete();

			DB::commit();

			return response()->json([
				'status' => 200,
				'message' => 'Your account has been deleted successfully.'
			], 200);
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => 500,
				'message' => 'Account deletion failed due to server error: ' . $e->getMessage() . " . Try again!"
			], 500);
		}
	}


}
