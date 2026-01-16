<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Announcement;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get active announcements
        $announcements = Announcement::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('display_order')
            ->get();

        // Get active home page banners
        $banners = Banner::where('status', 'active')
            ->whereIn('position', ['home_top', 'home_middle', 'home_bottom'])
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('position')
            ->orderBy('display_order')
            ->get();

        // Get home top banner for hero section
        $heroBanner = Banner::where('status', 'active')
            ->where('position', 'home_top')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('display_order')
            ->first();

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

        // Get main categories with active subcategories
        $categories = Category::where('status', 'active')
            ->whereNull('parent_id')
            ->with(['activeProducts', 'children' => function ($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('display_order')
            ->limit(8)
            ->get();

        // Get testimonials
        $testimonials = Testimonial::where('status', 'active')
            ->orderBy('display_order')
            ->limit(3)
            ->get();

        // Get middle banners
        $middleBanners = Banner::where('status', 'active')
            ->where('position', 'home_middle')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('display_order')
            ->limit(2)
            ->get();

        return view('home', compact(
            'announcements',
            'banners',
            'heroBanner',
            'featuredProducts',
            'bestSellers',
            'newArrivals',
            'categories',
            'testimonials',
            'middleBanners'
        ));
    }

    public function about()
    {
        return view('about');
    }
}
