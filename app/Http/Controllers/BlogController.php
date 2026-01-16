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

        // Get categories with post counts
        $categories = Blog::published()
            ->select('category')
            ->selectRaw('COUNT(*) as post_count')
            ->groupBy('category')
            ->orderBy('post_count', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category,
                    'slug' => strtolower(str_replace(' ', '-', $item->category)),
                    'posts_count' => $item->post_count
                ];
            });

        // Get total posts count
        $totalPosts = Blog::published()->count();

        // Get featured blog if needed
        $featuredBlog = Blog::published()
            ->with('author')
            ->orderBy('view_count', 'desc')
            ->orderBy('published_at', 'desc')
            ->first();

        return view('blog', compact('blogs', 'recentPosts', 'categories', 'totalPosts', 'featuredBlog'));
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