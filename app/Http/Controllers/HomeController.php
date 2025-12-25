<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with published blogs
     */
    public function index()
    {
        $blogs = Blog::with('user')
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('home', compact('blogs'));
    }

    /**
     * Display a single published blog
     */
    public function show(Blog $blog)
    {
        // Only show published blogs to public
        if ($blog->status !== 'published') {
            abort(404);
        }

        $blog->load('user');
        return view('blog-detail', compact('blog'));
    }
}
