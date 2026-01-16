<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['creator', 'parent'])
            ->withCount(['products'])
            ->latest()
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'active')->get();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'display_order' => 'nullable|integer|min:0',
            'category_image' => 'nullable|image|max:2048',
            'type' => 'required|in:featured,normal,popular',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('category_image')) {
            $validated['category_image'] = $request->file('category_image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['creator', 'parent', 'products', 'children']);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('status', 'active')
            ->where('id', '!=', $category->id)
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'display_order' => 'nullable|integer|min:0',
            'category_image' => 'nullable|image|max:2048',
            'type' => 'required|in:featured,normal,popular',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Update slug if name changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('category_image')) {
            // Delete old image
            if ($category->category_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->category_image);
            }
            $validated['category_image'] = $request->file('category_image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with products. Move products first.');
        }

        // Delete image
        if ($category->category_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($category->category_image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Request $request, Category $category)
    {
        $category->update([
            'status' => $category->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json(['success' => true]);
    }
}
