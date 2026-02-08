<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('status', 'published')
            ->with(['category', 'primaryImage', 'media']);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by price range
        if ($request->has('max_price')) {
            $query->where('best_price', '<=', $request->max_price);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->where('is_featured', true);
        }

        // Filter by best seller
        if ($request->has('best_seller')) {
            $query->where('is_best_seller', true);
        }

        // Filter by new arrival
        if ($request->has('new_arrival')) {
            $query->where('is_new_arrival', true);
        }

        // Filter by sale
        if ($request->has('sale')) {
            $query->whereNotNull('compare_at_price')
                  ->whereColumn('compare_at_price', '>', 'best_price');
        }

        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('best_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('best_price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc')
                      ->orderBy('total_reviews', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_reviews', 'desc')
                      ->orderBy('average_rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);
        
        $categories = Category::where('status', 'active')
            ->whereNull('parent_id')
            ->withCount(['products' => function($query) {
                $query->where('status', 'published');
            }])
            ->get();

        // Price range for filter
        $maxPrice = Product::where('status', 'published')->max('best_price');
        $totalProducts = Product::where('status', 'published')->count();

        return view('shop', compact(
            'products',
            'categories',
            'maxPrice',
            'totalProducts'
        ));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'media', 'variants', 'reviews.user'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->with(['primaryImage'])
            ->limit(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}