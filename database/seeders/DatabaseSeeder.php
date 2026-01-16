<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Blog;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ghazalifood.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 1,
            'status' => 'active'
        ]);

        // Create customer user
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@example.com',
            'password' => Hash::make('Password123'),
            'role_id' => 4,
            'status' => 'active'
        ]);

        // Create categories
        $categories = [
            ['name' => 'Fruits', 'slug' => 'fruits', 'type' => 'featured'],
            ['name' => 'Vegetables', 'slug' => 'vegetables', 'type' => 'popular'],
            ['name' => 'Dairy Products', 'slug' => 'dairy-products', 'type' => 'normal'],
            ['name' => 'Bakery', 'slug' => 'bakery', 'type' => 'normal'],
            ['name' => 'Beverages', 'slug' => 'beverages', 'type' => 'normal'],
            ['name' => 'Snacks', 'slug' => 'snacks', 'type' => 'normal'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create products
        $products = [
            [
                'name' => 'Organic Apples',
                'slug' => 'organic-apples',
                'category_id' => 1,
                'short_description' => 'Fresh organic apples from local farms',
                'full_description' => 'Delicious organic apples grown without pesticides.',
                'best_price' => 4.99,
                'compare_at_price' => 6.99,
                'is_featured' => true,
                'is_best_seller' => true,
                'status' => 'published'
            ],
            [
                'name' => 'Fresh Carrots',
                'slug' => 'fresh-carrots',
                'category_id' => 2,
                'short_description' => 'Crisp and sweet fresh carrots',
                'full_description' => 'Locally grown fresh carrots, perfect for cooking.',
                'best_price' => 2.99,
                'compare_at_price' => null,
                'is_new_arrival' => true,
                'status' => 'published'
            ],
            // Add more products...
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create banners
        Banner::create([
            'title' => 'Summer Sale',
            'description' => 'Up to 50% off on selected items',
            'position' => 'home_top',
            'display_order' => 1,
            'link_url' => '/shop',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'banner_image' => 'banners/summer-sale.jpg',
            'status' => 'active'
        ]);

        // Create blog posts
        Blog::create([
            'title' => '5 Healthy Eating Tips',
            'slug' => '5-healthy-eating-tips',
            'brief_description' => 'Learn how to eat healthy with these simple tips',
            'content' => 'Full content here...',
            'author_id' => 1,
            'category' => 'Nutrition',
            'featured_image' => 'blogs/healthy-eating.jpg',
            'is_published' => true,
            'published_at' => now(),
            'status' => 'published'
        ]);

        $this->command->info('Database seeded successfully!');
    }
}