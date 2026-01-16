<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Banner;
use App\Models\User;
use App\Models\Feedback;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_blogs' => Blog::count(),
            'total_users' => User::count(),
            'total_orders' => 0, // You'll add orders later
            'total_feedback' => Feedback::count(),
        ];
        
        $recentProducts = Product::latest()->limit(5)->get();
        $recentBlogs = Blog::latest()->limit(5)->get();
        $recentFeedback = Feedback::latest()->limit(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentBlogs', 'recentFeedback'));
    }
}