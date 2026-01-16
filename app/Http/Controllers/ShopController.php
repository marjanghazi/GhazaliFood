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
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('best_price', [
                $request->min_price,
                $request->max_price
            ]);
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

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
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
                $query->orderBy('average_rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('status', 'active')
            ->whereNull('parent_id')
            ->withCount(['products' => function($query) {
                $query->where('status', 'published');
            }])
            ->get();

        // Price range for filter
        $maxPrice = Product::where('status', 'published')->max('best_price');
        $minPrice = Product::where('status', 'published')->min('best_price');

        return view('shop', compact(
            'products',
            'categories',
            'maxPrice',
            'minPrice'
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