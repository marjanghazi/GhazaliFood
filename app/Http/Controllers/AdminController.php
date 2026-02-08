<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Banner;
use App\Models\Announcement;
use App\Models\Review;
use App\Models\Setting;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    // Define as constants
    const ORDER_STATUSES = [
        'pending',
        'processing',
        'shipped',
        'delivered',
        'cancelled',
        'refunded'
    ];
    const PAYMENT_STATUSES = [
        'pending',
        'paid',
        'failed',
        'refunded'
    ];

    public function dashboard()
    {
        // Get low stock threshold from settings
        $lowStockThreshold = Setting::getValue('low_stock_threshold', 10);

        // Stats
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_blogs' => Blog::count(),
            'total_users' => User::count(),
            'total_customers' => User::where('role_id', 4)->count(),
            'active_customers' => User::where('role_id', 4)->where('status', 'active')->count(),
            'new_customers_this_month' => User::where('role_id', 4)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'pending_reviews' => Review::where('status', 'pending')->count(),
            'active_coupons' => Coupon::where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('expiry_date', '>=', now())
                ->count(),
            'active_banners' => Banner::where('status', 'active')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'low_stock_products' => Product::where('stock_quantity', '<=', $lowStockThreshold)->count(),
        ];

        // Recent Products
        $recentProducts = Product::with(['category', 'primaryImage'])
            ->latest()
            ->limit(5)
            ->get();

        // Recent Feedback
        $recentFeedback = Feedback::latest()
            ->limit(5)
            ->get();

        // Recent Orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentFeedback', 'recentOrders'));
    }

    // Order Management Methods
    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.orders.index', [
            'title' => 'Order Management',
            'orders' => $orders,
            'useAdminLayout' => true
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return view('admin.orders.show', [
            'title' => 'Order Details #' . $order->order_number,
            'order' => $order,
            'useAdminLayout' => true
        ]);
    }

    public function editOrder($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return view('admin.orders.edit', [
            'title' => 'Edit Order #' . $order->order_number,
            'order' => $order,
            'statuses' => self::ORDER_STATUSES,
            'paymentStatuses' => self::PAYMENT_STATUSES,
            'useAdminLayout' => true
        ]);
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'cancelled_reason' => 'required_if:order_status,cancelled|string|max:500',
        ]);

        $updateData = [
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'tracking_number' => $request->tracking_number,
            'notes' => $request->notes,
        ];

        // Handle cancelled order
        if ($request->order_status === 'cancelled') {
            $updateData['cancelled_at'] = now();
            $updateData['cancelled_reason'] = $request->cancelled_reason;
        }

        // Handle delivered order
        if ($request->order_status === 'delivered') {
            $updateData['delivered_at'] = now();
        }

        $order->update($updateData);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order updated successfully!');
    }

    public function destroyOrder($id)
    {
        $order = Order::findOrFail($id);

        // Check if order can be deleted
        if (!in_array($order->order_status, ['cancelled', 'refunded'])) {
            return redirect()->back()->with('error', 'Cannot delete order that is not cancelled or refunded.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }

    public function printOrder($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.orders.print', [
            'order' => $order,
            'title' => 'Invoice #' . $order->order_number,
        ]);

        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    // Product Management Methods
    public function products()
    {
        $products = Product::with(['category', 'media' => function ($query) {
            $query->where('is_primary', true);
        }])->latest()->paginate(20);

        return view('admin.products.index', [
            'title' => 'Product Management',
            'products' => $products,
            'useAdminLayout' => true
        ]);
    }
    public function showProduct($id)
    {
        $product = Product::with(['category', 'reviews', 'variants'])->findOrFail($id);

        return view('admin.products.show', [
            'title' => 'Product Details: ' . $product->name,
            'product' => $product,
            'useAdminLayout' => true
        ]);
    }

    public function createProduct()
    {
        $categories = Category::all();

        return view('admin.products.create', [
            'title' => 'Create New Product',
            'categories' => $categories,
            'useAdminLayout' => true
        ]);
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'description' => 'required|string',
            'best_price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'barcode' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published,out_of_stock,discontinued',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the product first
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'short_description' => null,
            'full_description' => null,
            'best_price' => $request->best_price,
            'compare_at_price' => $request->compare_at_price,
            'cost_price' => $request->cost_price,
            'barcode' => $request->barcode,
            'stock_quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured'),
            'is_best_seller' => $request->has('is_bestseller'),
            'is_new_arrival' => false,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'created_by' => auth()->id(),
        ]);

        // Handle image uploads - FIXED: Use media() relationship instead of images()
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/' . $product->id, 'public');

                // Use media() relationship from Product model
                $product->media()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'display_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::with('media')->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'useAdminLayout' => true
        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'best_price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'barcode' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published,out_of_stock,discontinued',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:media,id',
        ]);

        // Update product data
        $product->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'short_description' => $product->short_description,
            'full_description' => $product->full_description,
            'best_price' => $request->best_price,
            'compare_at_price' => $request->compare_at_price,
            'cost_price' => $request->cost_price,
            'barcode' => $request->barcode,
            'stock_quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured'),
            'is_best_seller' => $request->has('is_bestseller'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        // Handle deletion of existing images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $media = $product->media()->find($imageId);
                if ($media) {
                    // Delete the file from storage
                    \Storage::disk('public')->delete($media->image_path);
                    $media->delete();
                }
            }

            // If primary image was deleted, set the first remaining image as primary
            $remainingImages = $product->media()->orderBy('display_order')->get();
            if ($remainingImages->count() > 0) {
                $firstImage = $remainingImages->first();
                if (!$firstImage->is_primary) {
                    $firstImage->update(['is_primary' => true]);
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            // Get the current max display order
            $currentMaxOrder = $product->media()->max('display_order') ?? -1;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/' . $product->id, 'public');

                // Determine if this should be primary (only if no images exist)
                $shouldBePrimary = ($product->media()->count() === 0 && $index === 0);

                $product->media()->create([
                    'image_path' => $path,
                    'is_primary' => $shouldBePrimary,
                    'display_order' => ++$currentMaxOrder,
                ]);
            }
        }

        // Reorder images if needed (ensure display_order is sequential)
        $this->reorderProductImages($product);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    private function reorderProductImages($product)
    {
        $images = $product->media()->orderBy('display_order')->get();

        foreach ($images as $index => $image) {
            if ($image->display_order !== $index) {
                $image->update(['display_order' => $index]);
            }
        }
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        // Check if product has orders
        if ($product->orders()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete product that has orders.');
        }

        // Delete associated media files
        foreach ($product->media as $media) {
            \Storage::disk('public')->delete($media->image_path);
            $media->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);

        $newStatus = $product->status === 'published' ? 'draft' : 'published';
        $product->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Product status updated successfully!');
    }

    public function toggleProductFeatured($id)
    {
        $product = Product::findOrFail($id);

        $product->update(['is_featured' => !$product->is_featured]);

        return redirect()->back()->with('success', 'Product featured status updated successfully!');
    }

    // Category Management Methods
    public function categories()
    {
        $categories = Category::withCount('products')->latest()->paginate(20);

        return view('admin.categories.index', [
            'title' => 'Category Management',
            'categories' => $categories,
            'useAdminLayout' => true
        ]);
    }

    public function showCategory($id)
    {
        $category = Category::with(['parent', 'children', 'products' => function ($query) {
            $query->latest()->limit(10);
        }])->findOrFail($id);

        return view('admin.categories.show', [
            'title' => 'Category Details: ' . $category->name,
            'category' => $category,
            'useAdminLayout' => true
        ]);
    }

    public function createCategory()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', [
            'title' => 'Create New Category',
            'parentCategories' => $categories,
            'useAdminLayout' => true
        ]);
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'display_order' => 'nullable|integer',
            'type' => 'required|in:normal,featured,popular',
            'status' => 'required|in:active,inactive'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'display_order' => $request->display_order ?? 0,
            'type' => $request->type,
            'status' => $request->status,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_id')->where('id', '!=', $id)->get();

        return view('admin.categories.edit', [
            'title' => 'Edit Category',
            'category' => $category,
            'parentCategories' => $categories,
            'useAdminLayout' => true
        ]);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'display_order' => 'nullable|integer',
            'type' => 'required|in:normal,featured,popular',
            'status' => 'required|in:active,inactive'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'display_order' => $request->display_order ?? $category->display_order,
            'type' => $request->type,
            'status' => $request->status
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category that has products. Please reassign products first.');
        }

        if ($category->children()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category that has subcategories. Please delete or reassign subcategories first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    // Customer Management Methods
    public function customers()
    {
        $customers = User::where('role_id', 4)->latest()->paginate(20);

        return view('admin.customers.index', [
            'title' => 'Customer Management',
            'customers' => $customers,
            'useAdminLayout' => true
        ]);
    }

    public function showCustomer($id)
    {
        $customer = User::where('role_id', 4)->findOrFail($id);

        return view('admin.customers.show', [
            'title' => 'Customer Details',
            'customer' => $customer,
            'useAdminLayout' => true
        ]);
    }

    public function editCustomer($id)
    {
        $customer = User::where('role_id', 4)->findOrFail($id);

        return view('admin.customers.edit', [
            'title' => 'Edit Customer: ' . $customer->name,
            'customer' => $customer,
            'useAdminLayout' => true
        ]);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = User::where('role_id', 4)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $customer->update($request->only('name', 'email', 'phone', 'status'));

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully!');
    }

    public function toggleCustomerStatus($id)
    {
        $customer = User::where('role_id', 4)->findOrFail($id);

        $statusTransitions = [
            'active' => 'inactive',
            'inactive' => 'active',
            'suspended' => 'active',
        ];

        $newStatus = $statusTransitions[$customer->status] ?? 'active';
        $customer->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Customer status updated successfully!');
    }

    public function destroyCustomer($id)
    {
        $customer = User::where('role_id', 4)->findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully!');
    }

    public function exportCustomers()
    {
        $customers = User::where('role_id', 4)->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Status',
                'Email Verified',
                'Last Login',
                'Total Orders',
                'Total Spent',
                'Created Date',
                'Updated Date'
            ]);

            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone ?? 'N/A',
                    $customer->status,
                    $customer->email_verified_at ? 'Yes' : 'No',
                    $customer->last_login_at ? $customer->last_login_at->format('Y-m-d H:i:s') : 'Never',
                    $customer->orders()->count(),
                    number_format($customer->orders()->sum('total_amount'), 2),
                    $customer->created_at->format('Y-m-d H:i:s'),
                    $customer->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // User Management Methods
    public function users()
    {
        $users = User::with('role')->latest()->paginate(20);

        return view('admin.users.index', [
            'title' => 'User Management',
            'users' => $users,
            'useAdminLayout' => true
        ]);
    }

    public function showUser($id)
    {
        $user = User::with('role')->findOrFail($id);

        return view('admin.users.show', [
            'title' => 'User Details',
            'user' => $user,
            'useAdminLayout' => true
        ]);
    }

    public function editUser($id)
    {
        $user = User::with('role')->findOrFail($id);

        return view('admin.users.edit', [
            'title' => 'Edit User: ' . $user->name,
            'user' => $user,
            'useAdminLayout' => true
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $user->update($request->only('name', 'email', 'role_id', 'status'));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    // Blog Management Methods
    public function blogs()
    {
        $blogs = Blog::latest()->paginate(20);

        return view('admin.blogs.index', [
            'title' => 'Blog Management',
            'blogs' => $blogs,
            'useAdminLayout' => true
        ]);
    }

    public function showBlog($id)
    {
        $blog = Blog::with('author')->findOrFail($id);

        return view('admin.blogs.show', [
            'title' => 'Blog Post: ' . $blog->title,
            'blog' => $blog,
            'useAdminLayout' => true
        ]);
    }

    public function createBlog()
    {
        return view('admin.blogs.create', [
            'title' => 'Create New Blog Post',
            'useAdminLayout' => true
        ]);
    }

    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:published,draft',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|array',
        ]);

        Blog::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'tags' => $request->tags ? json_encode($request->tags) : null,
            'author_id' => auth()->id(),
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }

    public function editBlog($id)
    {
        $blog = Blog::findOrFail($id);

        return view('admin.blogs.edit', [
            'title' => 'Edit Blog Post',
            'blog' => $blog,
            'useAdminLayout' => true
        ]);
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:published,draft',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|array',
        ]);

        $updateData = [
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'tags' => $request->tags ? json_encode($request->tags) : null,
        ];

        if ($request->status === 'published' && !$blog->published_at) {
            $updateData['published_at'] = now();
        } elseif ($request->status === 'draft') {
            $updateData['published_at'] = null;
        }

        $blog->update($updateData);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    public function toggleBlogPublish($id)
    {
        $blog = Blog::findOrFail($id);

        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => $blog->is_published ? null : now(),
            'status' => $blog->is_published ? 'draft' : 'published'
        ]);

        return redirect()->back()->with('success', 'Blog publish status updated successfully!');
    }

    public function destroyBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }

    // Feedback Management Methods
    public function feedback()
    {
        $feedbacks = Feedback::latest()->paginate(20);

        return view('admin.feedback.index', [
            'title' => 'Feedback Management',
            'feedbacks' => $feedbacks,
            'useAdminLayout' => true
        ]);
    }

    public function createFeedback()
    {
        $users = User::whereIn('role_id', [1, 2, 3])->get();

        return view('admin.feedback.create', [
            'title' => 'Create Feedback',
            'users' => $users,
            'useAdminLayout' => true
        ]);
    }

    public function storeFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'feedback_type' => 'required|in:general,complaint,suggestion,support,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'feedback_type' => $request->feedback_type,
            'status' => 'new',
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_by' => auth()->id()
        ]);

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback created successfully!');
    }

    public function showFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('admin.feedback.show', [
            'title' => 'Feedback Details',
            'feedback' => $feedback,
            'useAdminLayout' => true
        ]);
    }

    public function editFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $users = User::whereIn('role_id', [1, 2, 3])->get();

        return view('admin.feedback.edit', [
            'title' => 'Edit Feedback',
            'feedback' => $feedback,
            'users' => $users,
            'useAdminLayout' => true
        ]);
    }

    public function updateFeedback(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'response' => 'nullable|string|max:1000'
        ]);

        $updateData = [
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
        ];

        if ($request->filled('response')) {
            $updateData['response'] = $request->response;
            $updateData['responded_by'] = auth()->id();
            $updateData['responded_at'] = now();
        }

        $feedback->update($updateData);

        return redirect()->route('admin.feedback.show', $feedback)->with('success', 'Feedback updated successfully!');
    }

    public function destroyFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback deleted successfully!');
    }

    public function exportFeedback()
    {
        $feedback = Feedback::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feedback-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($feedback) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Type',
                'Subject',
                'Message',
                'Status',
                'Priority',
                'Response',
                'Responded By',
                'Responded At',
                'Created Date',
                'Updated Date'
            ]);

            foreach ($feedback as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->email,
                    $item->feedback_type,
                    $item->subject,
                    $item->message,
                    $item->status,
                    $item->priority,
                    $item->response ?? 'N/A',
                    $item->responded_by ? User::find($item->responded_by)->name : 'N/A',
                    $item->responded_at ? $item->responded_at->format('Y-m-d H:i:s') : 'N/A',
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // Review Management Methods
    public function reviews()
    {
        $reviews = Review::with('product', 'user')->latest()->paginate(20);

        return view('admin.reviews.index', [
            'title' => 'Review Management',
            'reviews' => $reviews,
            'useAdminLayout' => true
        ]);
    }

    public function approveReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 'approved']);

        return redirect()->route('admin.reviews.index')->with('success', 'Review approved successfully!');
    }

    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 'rejected']);

        return redirect()->route('admin.reviews.index')->with('success', 'Review rejected successfully!');
    }

    public function destroyReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }

    // Coupon Management Methods
    public function coupons()
    {
        $coupons = Coupon::latest()->paginate(20);

        return view('admin.coupons.index', [
            'title' => 'Coupon Management',
            'coupons' => $coupons,
            'useAdminLayout' => true
        ]);
    }

    public function showCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.show', [
            'title' => 'Coupon Details: ' . $coupon->code,
            'coupon' => $coupon,
            'useAdminLayout' => true
        ]);
    }

    public function toggleCouponStatus($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->update(['is_active' => !$coupon->is_active]);

        return redirect()->back()->with('success', 'Coupon status updated successfully!');
    }

    public function createCoupon()
    {
        return view('admin.coupons.create', [
            'title' => 'Create New Coupon',
            'useAdminLayout' => true
        ]);
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'usage_limit' => $request->usage_limit,
            'usage_per_user' => $request->usage_per_user,
            'start_date' => $request->start_date,
            'expiry_date' => $request->expiry_date,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
    }

    public function editCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', [
            'title' => 'Edit Coupon',
            'coupon' => $coupon,
            'useAdminLayout' => true
        ]);
    }

    public function updateCoupon(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'usage_limit' => $request->usage_limit,
            'usage_per_user' => $request->usage_per_user,
            'start_date' => $request->start_date,
            'expiry_date' => $request->expiry_date,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
    }

    public function destroyCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
    }

    // Banner Management Methods
    public function banners()
    {
        $banners = Banner::latest()->paginate(20);

        return view('admin.banners.index', [
            'title' => 'Banner Management',
            'banners' => $banners,
            'useAdminLayout' => true
        ]);
    }

    public function showBanner($id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banners.show', [
            'title' => 'Banner Details: ' . $banner->title,
            'banner' => $banner,
            'useAdminLayout' => true
        ]);
    }

    public function createBanner()
    {
        return view('admin.banners.create', [
            'title' => 'Create New Banner',
            'useAdminLayout' => true
        ]);
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'image' => 'required|image|max:2048',
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'position' => 'required|in:homepage_top,homepage_middle,sidebar',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'image_path' => $imagePath,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
    }

    public function editBanner($id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banners.edit', [
            'title' => 'Edit Banner',
            'banner' => $banner,
            'useAdminLayout' => true
        ]);
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'position' => 'required|in:homepage_top,homepage_middle,sidebar',
        ]);

        $updateData = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'position' => $request->position,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $updateData['image_path'] = $imagePath;
        }

        $banner->update($updateData);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroyBanner($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    }

    // Announcement Management Methods
    public function announcements()
    {
        $announcements = Announcement::latest()->paginate(20);

        return view('admin.announcements.index', [
            'title' => 'Announcement Management',
            'announcements' => $announcements,
            'useAdminLayout' => true
        ]);
    }

    public function showAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('admin.announcements.show', [
            'title' => 'Announcement Details: ' . $announcement->title,
            'announcement' => $announcement,
            'useAdminLayout' => true
        ]);
    }

    public function createAnnouncement()
    {
        return view('admin.announcements.create', [
            'title' => 'Create New Announcement',
            'useAdminLayout' => true
        ]);
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,success,danger',
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_dismissible' => 'boolean',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_dismissible' => $request->has('is_dismissible'),
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully!');
    }

    public function editAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('admin.announcements.edit', [
            'title' => 'Edit Announcement',
            'announcement' => $announcement,
            'useAdminLayout' => true
        ]);
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,success,danger',
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_dismissible' => 'boolean',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_dismissible' => $request->has('is_dismissible'),
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully!');
    }

    public function destroyAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully!');
    }

    // Reports Methods
    public function reports()
    {
        return view('admin.reports.index', [
            'title' => 'Reports Dashboard',
            'useAdminLayout' => true
        ]);
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth());
        $endDate = $request->get('end_date', now());

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        return view('admin.reports.sales', [
            'title' => 'Sales Report',
            'orders' => $orders,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'averageOrderValue' => $averageOrderValue,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'useAdminLayout' => true
        ]);
    }

    public function customersReport(Request $request)
    {
        $customers = User::where('role_id', 4)
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->paginate(20);

        return view('admin.reports.customers', [
            'title' => 'Customers Report',
            'customers' => $customers,
            'useAdminLayout' => true
        ]);
    }

    public function productsReport(Request $request)
    {
        $products = Product::withCount('orders')
            ->withSum('orders', 'quantity')
            ->orderBy('orders_count', 'desc')
            ->paginate(20);

        return view('admin.reports.products', [
            'title' => 'Products Report',
            'products' => $products,
            'useAdminLayout' => true
        ]);
    }

    // Settings Methods
    public function settings()
    {
        $settingValues = Setting::all()->pluck('value', 'key')->toArray();

        $defaults = [
            'site_name' => config('app.name', 'Ghazali Food'),
            'site_email' => config('mail.from.address', 'admin@ghazalifood.com'),
            'site_phone' => '+1 (234) 567-8900',
            'site_address' => '123 Food Street, Karachi, Pakistan',
            'currency_code' => 'PKR',
            'currency_symbol' => 'Rs',
            'currency_position' => 'left',
            'decimal_places' => 2,
            'tax_enabled' => true,
            'tax_rate' => 16,
            'shipping_enabled' => true,
            'shipping_cost' => 200,
            'free_shipping_threshold' => 5000,
            'low_stock_threshold' => 10,
            'maintenance_mode' => false,
            'maintenance_message' => 'Site is currently under maintenance. Please check back later.',
            'allow_admin_access' => true,
            'cache_duration' => 60,
            'backup_frequency' => 'daily',
            'review_approval_required' => true,
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i:s',
            'timezone' => 'Asia/Karachi',
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => 587,
            'mail_username' => '',
            'mail_password' => '',
            'mail_encryption' => 'tls',
            'mail_from_address' => config('mail.from.address', 'admin@ghazalifood.com'),
            'mail_from_name' => config('app.name', 'Ghazali Food'),
            'order_notification_email' => '',
            'support_email' => '',
            'payment_gateway' => 'cod',
            'stripe_key' => '',
            'stripe_secret' => '',
            'stripe_webhook_secret' => '',
            'paypal_client_id' => '',
            'paypal_secret' => '',
            'paypal_sandbox' => true,
            'cod_enabled' => true,
            'bank_transfer_enabled' => false,
            'bank_details' => "Bank Name: HBL\nAccount Name: Ghazali Food\nAccount Number: 1234567890\nIBAN: PK00HBL01234567890\nBranch: Main Branch, Karachi"
        ];

        $settingValues = array_merge($defaults, $settingValues);

        return view('admin.settings.index', [
            'title' => 'System Settings',
            'settingValues' => $settingValues,
            'useAdminLayout' => true
        ]);
    }

    public function updateSettings(Request $request)
    {
        $settingsData = $request->except('_token', '_method');

        foreach ($settingsData as $key => $value) {
            Setting::set($key, $value);
        }

        Cache::forget('settings.all');
        Cache::forget('settings.grouped');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }

    public function updateGeneralSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
            'currency_code' => 'required|string|size:3',
            'currency_symbol' => 'required|string|max:10',
            'currency_position' => 'required|in:left,right,left_with_space,right_with_space',
            'decimal_places' => 'required|integer|min:0|max:4',
            'timezone' => 'required|string|max:100',
            'date_format' => 'required|string|max:50',
            'time_format' => 'required|string|max:50',
        ]);

        $settings = [
            'site_name' => $request->site_name,
            'site_email' => $request->site_email,
            'site_phone' => $request->site_phone,
            'site_address' => $request->site_address,
            'currency_code' => $request->currency_code,
            'currency_symbol' => $request->currency_symbol,
            'currency_position' => $request->currency_position,
            'decimal_places' => $request->decimal_places,
            'timezone' => $request->timezone,
            'date_format' => $request->date_format,
            'time_format' => $request->time_format,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        Cache::forget('settings.all');
        Cache::forget('settings.grouped');

        return redirect()->route('admin.settings.index')->with('success', 'General settings updated successfully!');
    }

    public function updateEmailSettings(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string|max:50',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:10',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        $settings = [
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        Cache::forget('settings.all');
        Cache::forget('settings.grouped');

        return redirect()->route('admin.settings.index')->with('success', 'Email settings updated successfully!');
    }

    public function updatePaymentSettings(Request $request)
    {
        $request->validate([
            'payment_gateway' => 'required|string|in:stripe,paypal,cod,bank_transfer',
            'stripe_key' => 'required_if:payment_gateway,stripe|string|max:255',
            'stripe_secret' => 'required_if:payment_gateway,stripe|string|max:255',
            'stripe_webhook_secret' => 'nullable|string|max:255',
            'paypal_client_id' => 'required_if:payment_gateway,paypal|string|max:255',
            'paypal_secret' => 'required_if:payment_gateway,paypal|string|max:255',
            'tax_enabled' => 'boolean',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'shipping_enabled' => 'boolean',
            'shipping_cost' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
        ]);

        $settings = [
            'payment_gateway' => $request->payment_gateway,
            'stripe_key' => $request->stripe_key,
            'stripe_secret' => $request->stripe_secret,
            'stripe_webhook_secret' => $request->stripe_webhook_secret,
            'paypal_client_id' => $request->paypal_client_id,
            'paypal_secret' => $request->paypal_secret,
            'tax_enabled' => $request->has('tax_enabled'),
            'tax_rate' => $request->tax_rate,
            'shipping_enabled' => $request->has('shipping_enabled'),
            'shipping_cost' => $request->shipping_cost,
            'free_shipping_threshold' => $request->free_shipping_threshold,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        Cache::forget('settings.all');
        Cache::forget('settings.grouped');

        return redirect()->route('admin.settings.index')->with('success', 'Payment settings updated successfully!');
    }

    public function updateMaintenanceSettings(Request $request)
    {
        $request->validate([
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string|max:1000',
            'allow_admin_access' => 'boolean',
            'low_stock_threshold' => 'required|integer|min:1',
            'cache_duration' => 'required|integer|min:1',
            'review_approval_required' => 'boolean',
        ]);

        $settings = [
            'maintenance_mode' => $request->has('maintenance_mode'),
            'maintenance_message' => $request->maintenance_message,
            'allow_admin_access' => $request->has('allow_admin_access'),
            'low_stock_threshold' => $request->low_stock_threshold,
            'cache_duration' => $request->cache_duration,
            'review_approval_required' => $request->has('review_approval_required'),
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        Cache::forget('settings.all');
        Cache::forget('settings.grouped');

        return redirect()->route('admin.settings.index')->with('success', 'Maintenance settings updated successfully!');
    }

    // Admin Profile Methods
    public function adminProfile()
    {
        return view('admin.profile.index', [
            'title' => 'Admin Profile',
            'user' => auth()->user(),
            'useAdminLayout' => true
        ]);
    }

    public function updateAdminProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed'
        ]);

        $data = $request->only('name', 'email', 'phone');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.profile.index')->with('success', 'Profile updated successfully!');
    }

    public function backupDatabase()
    {
        try {
            $fileName = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
            $filePath = storage_path('app/backups/' . $fileName);

            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            $content = "-- Database Backup\n";
            $content .= "-- Date: " . date('Y-m-d H:i:s') . "\n";
            $content .= "-- App: " . config('app.name') . "\n\n";

            $content .= "-- Table Statistics\n";
            $tables = ['users', 'products', 'categories', 'orders', 'blogs', 'reviews'];
            foreach ($tables as $table) {
                try {
                    $count = \DB::table($table)->count();
                    $content .= "-- {$table}: {$count} records\n";
                } catch (\Exception $e) {
                    $content .= "-- {$table}: ERROR - " . $e->getMessage() . "\n";
                }
            }

            file_put_contents($filePath, $content);

            return Response::download($filePath, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            \Artisan::call('route:clear');

            Cache::forget('settings.all');
            Cache::forget('settings.grouped');

            return redirect()->route('admin.settings.index')
                ->with('success', 'Cache cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            $email = $request->email;

            \Mail::raw('This is a test email from ' . config('app.name'), function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test Email from ' . config('app.name'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 500);
        }
    }
}
