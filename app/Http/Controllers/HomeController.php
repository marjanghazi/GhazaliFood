<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get active banners
        $banners = Banner::active()
            ->position('home_top')
            ->orderBy('display_order')
            ->get();

        // Get featured products
        $featuredProducts = Product::where('is_featured', true)
            ->where('status', 'published')
            ->with(['category', 'primaryImage'])
            ->limit(8)
            ->get();

        // Get best sellers
        $bestSellers = Product::where('is_best_seller', true)
            ->where('status', 'published')
            ->with(['category', 'primaryImage'])
            ->limit(6)
            ->get();

        // Get new arrivals
        $newArrivals = Product::where('is_new_arrival', true)
            ->where('status', 'published')
            ->with(['category', 'primaryImage'])
            ->limit(6)
            ->get();

        // Get categories
        $categories = Category::where('status', 'active')
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('status', 'active');
            }])
            ->limit(8)
            ->get();

        return view('home', compact(
            'banners',
            'featuredProducts',
            'bestSellers',
            'newArrivals',
            'categories'
        ));
    }

    public function about()
    {
        return view('about');
    }
}