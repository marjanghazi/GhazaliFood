<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $recentPosts = Blog::published()
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        $categories = Blog::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('blog', compact('blogs', 'recentPosts', 'categories'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->with('author')
            ->firstOrFail();

        // Increment view count
        $blog->incrementViewCount();

        $recentPosts = Blog::published()
            ->where('id', '!=', $blog->id)
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return view('blog-detail', compact('blog', 'recentPosts'));
    }
}