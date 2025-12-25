<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    /**
     * Display all blogs for admin review
     */
    public function index()
    {
        $blogs = Blog::with('user')->latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Display the specified blog
     */
    public function show(Blog $blog)
    {
        $blog->load('user');
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Update blog status via AJAX
     */
    public function updateStatus(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,published,rejected',
        ]);

        $blog->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Blog status updated successfully!',
            'status' => $blog->status,
        ]);
    }
}
