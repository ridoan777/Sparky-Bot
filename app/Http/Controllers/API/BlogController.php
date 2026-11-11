<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $blogs = Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => BlogResource::collection($blogs),
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total()
            ]
        ]);
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param  \App\Http\Requests\BlogRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BlogRequest $request)
    {

        $blog = new Blog();
        $blog->user_id = Auth::id();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title) . '-' . Str::random(5);
        $blog->content = $request->content;
        $blog->excerpt = $request->excerpt;
        $blog->featured_image = $request->featured_image;
        $blog->status = $request->status;
        
        if ($request->status === 'published') {
            $blog->published_at = now();
        }
        
        $blog->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully',
            'data' => new BlogResource($blog)
        ], 201);
    }

    /**
     * Display the specified blog.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        if (!$blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new BlogResource($blog)
        ]);
    }

    /**
     * Update the specified blog in storage.
     *
     * @param  \App\Http\Requests\BlogRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found'
            ], 404);
        }

        // Check if the authenticated user is the owner of the blog
        if ($blog->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Update the blog
        $blog->title = $request->title;
        
        // Only update slug if title has changed
        if ($blog->title !== $request->title) {
            $blog->slug = Str::slug($request->title) . '-' . Str::random(5);
        }
        
        $blog->content = $request->content;
        $blog->excerpt = $request->excerpt;
        $blog->featured_image = $request->featured_image;
        
        // If status is changing from draft to published, set published_at
        if ($blog->status === 'draft' && $request->status === 'published') {
            $blog->published_at = now();
        }
        
        $blog->status = $request->status;
        $blog->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog updated successfully',
            'data' => new BlogResource($blog)
        ]);
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found'
            ], 404);
        }

        // Check if the authenticated user is the owner of the blog
        if ($blog->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $blog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog deleted successfully'
        ]);
    }

    /**
     * Get blogs by authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myBlogs()
    {
        $blogs = Blog::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => BlogResource::collection($blogs),
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total()
            ]
        ]);
    }
}