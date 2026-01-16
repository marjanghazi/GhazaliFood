<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['author'])
            ->latest()
            ->paginate(20);
        
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Blog::select('category')->distinct()->pluck('category');
        
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brief_description' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'required|image|max:2048',
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string',
            'seo_meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['author_id'] = auth()->id();
        
        // Handle tags
        if ($request->has('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }
        
        // Upload featured image
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }
        
        // Set published_at if published
        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = $request->published_at ?? now();
            $validated['status'] = 'published';
        } else {
            $validated['status'] = 'draft';
        }
        
        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function show(Blog $blog)
    {
        $blog->load(['author']);
        
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Blog::select('category')->distinct()->pluck('category');
        
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brief_description' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string',
            'seo_meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        // Handle tags
        if ($request->has('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }
        
        // Upload new featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }
        
        // Update published status
        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = $request->published_at ?? $blog->published_at ?? now();
            $validated['status'] = 'published';
        } elseif (!$request->has('is_published')) {
            $validated['status'] = 'draft';
        }
        
        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    public function togglePublish(Request $request, Blog $blog)
    {
        if ($blog->is_published) {
            $blog->update([
                'is_published' => false,
                'status' => 'draft'
            ]);
        } else {
            $blog->update([
                'is_published' => true,
                'published_at' => now(),
                'status' => 'published'
            ]);
        }

        return response()->json(['success' => true]);
    }
}