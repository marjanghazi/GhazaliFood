<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductMedia;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'media'])
            ->latest()
            ->paginate(20);
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        $variants = Variant::where('status', 'active')->get();
        
        return view('admin.products.create', compact('categories', 'variants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'best_price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'type' => 'required|in:simple,variable,grouped',
            'status' => 'required|in:draft,published,out_of_stock,discontinued',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['created_by'] = auth()->id();

        // Create product
        $product = Product::create($validated);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('products', 'public');
                
                ProductMedia::create([
                    'product_id' => $product->id,
                    'media_type' => 'image',
                    'media_url' => $path,
                    'alt_text' => $validated['name'],
                    'display_order' => $key,
                    'is_primary' => $key === 0
                ]);
            }
        }

        // Handle variants if product is variable
        if ($request->type === 'variable' && $request->has('variants')) {
            // You'll need to implement variant handling
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'media', 'variants', 'reviews']);
        
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        $variants = Variant::where('status', 'active')->get();
        
        return view('admin.products.edit', compact('product', 'categories', 'variants'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'best_price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'type' => 'required|in:simple,variable,grouped',
            'status' => 'required|in:draft,published,out_of_stock,discontinued',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new_arrival' => 'boolean',
        ]);

        // Update product
        $product->update($validated);

        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('products', 'public');
                
                ProductMedia::create([
                    'product_id' => $product->id,
                    'media_type' => 'image',
                    'media_url' => $path,
                    'alt_text' => $validated['name'],
                    'display_order' => $product->media()->count() + $key,
                    'is_primary' => false
                ]);
            }
        }

        // Handle image deletions
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $media = ProductMedia::find($imageId);
                if ($media) {
                    Storage::disk('public')->delete($media->media_url);
                    $media->delete();
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete images
        foreach ($product->media as $media) {
            Storage::disk('public')->delete($media->media_url);
            $media->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'published' ? 'draft' : 'published'
        ]);

        return response()->json(['success' => true]);
    }

    public function toggleFeatured(Product $product)
    {
        $product->update([
            'is_featured' => !$product->is_featured
        ]);

        return response()->json(['success' => true]);
    }
}