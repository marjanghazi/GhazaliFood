<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products
        $featuredProducts = Product::where('status', 'published')
            ->where('is_featured', true)
            ->with(['primaryImage', 'category'])
            ->latest()
            ->take(8)
            ->get();

        // Get new arrival products
        $newArrivals = Product::where('status', 'published')
            ->where('is_new_arrival', true)
            ->with(['primaryImage', 'category'])
            ->latest()
            ->take(6)
            ->get();

        // Get categories for shop by category section
        $categories = Category::whereNull('parent_id')
            ->where('status', 'active')
            ->with(['children' => function($query) {
                $query->active()->orderBy('display_order');
            }])
            ->orderBy('display_order')
            ->take(8)
            ->get();

        // Get testimonials
        $testimonials = Testimonial::where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        // Get latest blog posts
        $latestBlogs = Blog::where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('home', [
            'title' => 'Premium Dry Fruits Store | Nuts & Berries',
            'description' => 'Premium quality dry fruits, nuts, and berries. 100% natural, organic, and sourced from the finest orchards worldwide.',
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $newArrivals,
            'categories' => $categories,
            'testimonials' => $testimonials,
            'latestBlogs' => $latestBlogs
        ]);
    }

    public function about()
    {
        return view('about', [
            'title' => 'About Us - Nuts & Berries',
            'description' => 'Learn about our story, mission, and commitment to providing premium quality dry fruits.'
        ]);
    }
}