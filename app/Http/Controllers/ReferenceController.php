<?php

namespace App\Http\Controllers;

use App\Helpers\StoreImage;
use App\Models\ReferenceCategory;
use App\Models\ReferencePage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Reference\Reference;

class ReferenceController extends Controller
{

	public function index()
	{
		$categories = ReferenceCategory::with('refCategoryRelationWith_pages')->orderBy('order', 'ASC')->get();

		return response()->json([
			'status' => 200,
			'categories' => $categories,
		]);
	}

	public function createViaApi(Request $request)	// for api
	{
		try {
			$validator = Validator::make($request->all(), [
				'name' => ['required', 'string', 'regex:/^[A-Za-z0-9\-\._ ]*$/', 'max:60'],
				'description' => ['nullable', 'string', 'regex:/^[A-Za-z0-9\-\._ ]*$/', 'max:300'],
				'order' => 'required|numeric',

				'content' => 'required|array',
				// 'content.*.img_id' => ['required', 'string', 'regex:/^[A-Za-z0-9\-\._ ]*$/'],
				'content.*.title' => ['required', 'string', 'regex:/^[A-Za-z0-9\-\._ ]*$/', 'max:60'],
				'content.*.details' => ['nullable', 'string', 'max:600'],
				'content.*.file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
				'content.*.ref_pdf_page' => 'nullable|numeric',
				'content.*.order' => 'numeric',
			]);
			if ($validator->fails()) {
				return response()->json([
					'status' => 422,
					'message' => 'validation error',
					'data' => $validator->errors()->all()
				]);
			}

			$validated = $validator->validated();

			$refCategory = ReferenceCategory::create([
				'name' => $validated['name'],
				'description' => $validated['description'],
				'order' => $validated['order'],
			]);

			$contentCreated = [];
			foreach ($validated['content'] as $index => $item) {
				$path = $item['file'] ?? 'no-content';
				$img_id = 'N/A';

				if ($request->hasFile("content.$index.file")) {
					$uploadedFile = $request->file("content.$index.file");

					$path = StoreImage::storeFile(
						$uploadedFile,
						$item['title'],
						'reference-pics',
						'public'
					);
					$img_id = StoreImage::getDirectoryFreeName();
				}

				$content = $refCategory->refCategoryRelationWith_pages()->create([
					'img_id' => $img_id,
					'title' => $item['title'],
					'details' => $item['details'],
					'path' => $path,
					'ref_pdf_page' => $item['ref_pdf_page'] ?? null,
					'order' => $item['order'] ?? 0,
				]);

				$contentCreated[] = $content;
			}

			return response()->json([
				'status' => 200,
				'category' => $refCategory,
				'content' => $contentCreated,
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

	public function create()
	{
		return view('backend.layouts.reference.categoryCreate');
	}

	public function store(Request $request)	// for web
	{
		try {
			$validator = Validator::make($request->all(), [
				'name' => ['required', 'string', 'max:200'],
				// 'description' => ['nullable', 'string', 'regex:/^[A-Za-z0-9\-\._ ]*$/', 'max:300'],
				'description' => ['nullable', 'string', 'max:2000'],
				'order' => 'required|numeric',

				'content' => 'required|array',
				// 'content.*.img_id' => ['required', 'string', 'regex:/^[A-Za-z0-9\-\._ ]*$/'],
				'content.*.title' => ['required', 'string', 'max:200'],
				'content.*.details' => ['nullable', 'string', 'max:600'],
				'content.*.file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
				'content.*.ref_pdf_page' => 'nullable|numeric',
			]);

			if ($validator->fails()) {
				dd("fails", $validator->errors());
				return redirect()->back()->withErrors($validator)->withInput();
			}
			// dd($request->all());
			$validated = $validator->validated();

			$refCategory = ReferenceCategory::create([
				'name' => $validated['name'],
				'description' => $validated['description'],
				'order' => $validated['order'],
			]);

			$contentCreated = [];

			foreach ($validated['content'] as $index => $item) {
				$path = $item['file'] ?? 'no-content';
				$img_id = 'N/A-' . uniqid();

				if ($request->hasFile("content.$index.file")) {
					$uploadedFile = $request->file("content.$index.file");

					$path = StoreImage::storeFile(
						$uploadedFile,
						$item['title'],
						'reference-pics',
						'public'
					);
					$img_id = StoreImage::getDirectoryFreeName();
				}

				$content = $refCategory->refCategoryRelationWith_pages()->create([
					'img_id' => $img_id,
					'title' => $item['title'],
					'details' => $item['details'],
					'path' => $path,
					'ref_pdf_page' => $item['ref_pdf_page'] ?? null,
				]);

				$contentCreated[] = $content;
			}

			return redirect()->route('admin.reference.index')->with("success", "Reference category created");

		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error',
				'errors' => $e->getMessage()
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		}
	}


	public function editCategory(ReferenceCategory $refCategory)
	{
		$refCategory = ReferenceCategory::with('refCategoryRelationWith_pages')->find($refCategory->id);
		// dd($refCategory);
		return view('backend.layouts.reference.categoryEdit', compact('refCategory'));
	}

	public function editContent(ReferencePage $refContent)
	{
		return view('backend.layouts.reference.contentEdit', compact('refContent'));
	}


	public function updateCategory(Request $request, $id)
	{
		// dd($request->all());
		try {
			$validator = Validator::make($request->all(), [
				'name' => ['required', 'string', 'max:200'],
				'description' => ['nullable', 'string', 'max:2000'],
				'order' => 'required|numeric',
				'content' => 'required|array',
				'content.*.id' => 'nullable|exists:reference_pages,id',
				'content.*.title' => ['required', 'string', 'max:200'],
				'content.*.details' => ['nullable', 'string', 'max:600'],
				'content.*.file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
				'content.*.ref_pdf_page' => 'nullable|numeric',
			]);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$refCategory = ReferenceCategory::find($id);
			$validated = $validator->validated();

			// -------------updating the category-------------
			$refCategory->update([
				'name' => $validated['name'],
				'description' => $validated['description'],
				'order' => $validated['order'],
			]);

			$contentCreated = [];
			$existingContents = $refCategory->refCategoryRelationWith_pages()->get()->keyBy('id');

			$category_id = $existingContents->first()->category_id;
			;

			$processedIds = [];

			// -------------looping each category content-------------
			foreach ($validated['content'] as $index => $item) {
				$itemId = !empty($item['id']) ? (int) $item['id'] : null;
				$existingContent = $itemId ? ($existingContents[$itemId] ?? null) : null;

				$path = 'no-content';
				$img_id = 'N/A-' . time();



				if ($request->hasFile("content.$index.file")) {
					$uploadedFile = $request->file("content.$index.file");
					$path = StoreImage::storeFile(
						$uploadedFile,
						$item['title'],
						'reference-pics',
						'public'
					);
					$img_id = StoreImage::getDirectoryFreeName();
				}

				if ($existingContent) {
					// Update existing child - only update file fields if new file uploaded
					$updateData = [
						'title' => $item['title'],
						'details' => $item['details'] ?? null,
						'ref_pdf_page' => $item['ref_pdf_page'] ?? null,
					];

					// Only update file-related fields if a new file was uploaded
					if ($request->hasFile("content.$index.file")) {
						$updateData['img_id'] = $img_id;
						$updateData['path'] = $path;
					}

					$existingContent->update($updateData);

					$processedIds[] = $itemId;

				} else {// create if content doesn't exist
					$newContent = $refCategory->refCategoryRelationWith_pages()->create([
						'img_id' => $img_id,
						'title' => $item['title'],
						'details' => $item['details'] ?? null,
						'path' => $path,
						'ref_pdf_page' => $item['ref_pdf_page'] ?? null,
					]);

					// important for storing IDs else it will be deleted in whereNotIn(..)
					$processedIds[] = $newContent->id;
				}
			}

			// -------------delete removed contents-------------
			if (!empty($processedIds)) {
				$contentsToDelete = $refCategory->refCategoryRelationWith_pages()->whereNotIn('id', $processedIds)->get();

				foreach ($contentsToDelete as $contentToDelete) {
					if ($contentToDelete->path && $contentToDelete->path !== 'no-content') {
						\Illuminate\Support\Facades\Storage::disk('public')->delete($contentToDelete->path);
					}
				}

				$refCategory->refCategoryRelationWith_pages()->whereNotIn('id', $processedIds)->delete();
			}

			return redirect()->route('admin.reference.index')->with("success", "Reference category updated");

		} catch (QueryException $e) {
			\Log::error('Database error in updateCategory: ' . $e->getMessage());
			return redirect()->back()
				->withErrors(['error' => 'Database error occurred'])
				->withInput();
		} catch (\Exception $e) {
			\Log::error('Error in updateCategory: ' . $e->getMessage());
			return redirect()->back()
				->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
				->withInput();
		}
	}

	public function updateContent(Request $request, ReferencePage $refContent)
	{
		try {
			$validator = Validator::make($request->all(), [
				'title' => ['nullable', 'string', 'max:200'],
				'details' => ['nullable', 'string', 'max:2000'],
				'ref_pdf_page' => ['nullable', 'numeric'],
				'category_name' => ['nullable', 'string', 'max:200'],
				'file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
			]);

			if ($validator->fails()) {
				return response()->json([
					'status' => 422,
					'message' => 'Validation error',
					'data' => $validator->errors()->all()
				]);
			}

			$validated = $validator->validated();

			if (!empty($validated['category_name'])) {
				$category = $refContent->refPageRetalationWith_category;
				if ($category) {
					$category->update([
						'name' => $validated['category_name']
					]);
				}
			}

			// Update file if uploaded
			if ($request->hasFile('file')) {

				$uploadedFile = $request->file('file');
				$path = StoreImage::storeFile(
					$uploadedFile,
					$validated['title'],
					'reference-pics',
					'public'
				);
				$img_id = StoreImage::getDirectoryFreeName();

				$refContent->update([
					'img_id' => $img_id,
					'path' => $path,
				]);
			}

			// Update other fields
			$refContent->update([
				'title' => $validated['title'],
				'details' => $validated['details'],
				'ref_pdf_page' => $validated['ref_pdf_page'] ?? $refContent->ref_pdf_page,
			]);

			return redirect()->route('admin.reference.index');

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

	public function deleteCategory(ReferenceCategory $refCategory)
	{
		$contents = $refCategory->refCategoryRelationWith_pages;

		foreach ($contents as $content) {
			if ($content->path && $content->path !== 'no-content') {
				\Illuminate\Support\Facades\Storage::disk('public')->delete($content->path);
			}
		}
		$refCategory->delete();

		return redirect()->route('admin.reference.index')->with("success", "Reference category deleted");
	}

	public function deleteContent(ReferencePage $refContent)
	{
		if ($refContent->path && $refContent->path !== 'no-content') {
			\Illuminate\Support\Facades\Storage::disk('public')->delete($refContent->path);
		}
		$refContent->delete();

		return redirect()->route('admin.reference.index')->with("success", "Reference Content deleted");
	}

	public function search(Request $request)
	{
		$searchParam = $request->query('q');

		if ($searchParam) {
			// Search categories
			$matchedCategories = ReferenceCategory::search($searchParam)->get();
			$matchedCategoryIds = $matchedCategories->pluck('id');

			// Search pages
			$matchedPages = ReferencePage::search($searchParam)->get();
			$matchedPageIds = $matchedPages->pluck('id');
			$matchedCategoryIdsFromPages = $matchedPages->pluck('category_id');

			// Merge categories from both matches
			$allCategoryIds = $matchedCategoryIds
				->merge($matchedCategoryIdsFromPages)
				->unique();

			// Load categories with filtered children
			$categories = ReferenceCategory::with([
				'refCategoryRelationWith_pages' => function ($query) use ($matchedPageIds, $matchedCategoryIds) {
					// if the category itself matched, include ALL children
					if ($matchedCategoryIds->count()) {
						// do nothing: eager load all children
					} else {
						// otherwise, only load matching children
						$query->whereIn('id', $matchedPageIds);
					}
				}
			])
				->whereIn('id', $allCategoryIds)
				->orderBy('order', 'ASC')
				->get();

			$pages = $matchedPages;
		} else {
			// No search → load everything
			$categories = ReferenceCategory::with('refCategoryRelationWith_pages')
				->orderBy('order', 'ASC')
				->get();
			$pages = ReferencePage::all();
		}
		return view('backend.layouts.reference.index', compact('pages', 'searchParam', 'categories'));
	}

	public function api_search(Request $request)
	{
		$searchParam = $request->query('q');

		if ($searchParam) {
			// Search categories
			$matchedCategories = ReferenceCategory::search($searchParam)->get();
			$matchedCategoryIds = $matchedCategories->pluck('id');

			// Search pages
			$matchedPages = ReferencePage::search($searchParam)->get();
			$matchedPageIds = $matchedPages->pluck('id');
			$matchedCategoryIdsFromPages = $matchedPages->pluck('category_id');

			// Merge categories from both matches
			$allCategoryIds = $matchedCategoryIds
				->merge($matchedCategoryIdsFromPages)
				->unique();

			// Load categories with filtered children
			$categories = ReferenceCategory::with([
				'refCategoryRelationWith_pages' => function ($query) use ($matchedPageIds, $matchedCategoryIds) {
					// if the category itself matched, include ALL children
					if ($matchedCategoryIds->count()) {
						// do nothing: eager load all children
					} else {
						// otherwise, only load matching children
						$query->whereIn('id', $matchedPageIds);
					}
				}
			])
				->whereIn('id', $allCategoryIds)
				->orderBy('order', 'ASC')
				->get();

			$pages = $matchedPages;
		} else {
			// No search → load everything
			$categories = ReferenceCategory::with('refCategoryRelationWith_pages')
				->orderBy('order', 'ASC')
				->get();
			$pages = ReferencePage::all();
		}

		// dd($pages, $searchParam, $categories);
		return response()->json([
			'status' => 200,
			'search' => $searchParam,
			'categories' => $categories->map(function ($category) {
				return [
					'id' => $category->id,
					'name' => $category->name,
					'description' => $category->description,
					'pages' => $category->refCategoryRelationWith_pages->map(function ($page) {
						return [
							'id' => $page->id,
							'img_id' => $page->img_id,
							'title' => $page->title,
							'details' => $page->details,
							'path' => $page->path,
							'ref_pdf_page' => $page->ref_pdf_page,
						];
					})->values(), // reindex the collection for JSON
				];
			})->values(),
		]);


	}

	public function show($id)
	{
		$content = ReferenceCategory::with('refCategoryRelationWith_pages')
			->find($id);

		if (!$content) {
			return response()->json([
				'status' => 404,
				'message' => 'Category not found',
			]);
		}

		return response()->json([
			'status' => 200,
			'content' => $content,
		]);
	}

}
