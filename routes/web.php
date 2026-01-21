<?php

use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\CategoryController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/categories', [ShopController::class, 'categories'])->name('categories.index');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category.show');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist')->middleware('auth');

// Wishlist API Routes (with prefix)
Route::prefix('wishlist')->name('wishlist.')->middleware('auth')->group(function () {
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
    Route::post('/add', [WishlistController::class, 'store'])->name('add');
    Route::delete('/remove/{id}', [WishlistController::class, 'destroy'])->name('remove');
    Route::get('/count', [WishlistController::class, 'count'])->name('count');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================================
// USER PROFILE ROUTES
// ============================================================================

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    // Main profile routes
    Route::get('/', [AuthController::class, 'profile'])->name('edit');
    Route::put('/', [AuthController::class, 'updateProfile'])->name('update');
    
    // Password change routes
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('update-password');
    
    // Shipping Addresses routes
    Route::get('/addresses', [AuthController::class, 'shippingAddresses'])->name('shipping-addresses');
    Route::get('/addresses/create', [AuthController::class, 'createShippingAddress'])->name('addresses.create');
    Route::post('/addresses', [AuthController::class, 'storeShippingAddress'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AuthController::class, 'editShippingAddress'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AuthController::class, 'updateShippingAddress'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AuthController::class, 'destroyShippingAddress'])->name('addresses.destroy');
    
    // Wishlist routes
    Route::get('/wishlist', [AuthController::class, 'wishlist'])->name('wishlist');
});

// Orders routes (keep these separate)
Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [AuthController::class, 'orders'])->name('index');
    Route::get('/{id}', [AuthController::class, 'orderDetails'])->name('show');
});

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews')->middleware('auth');

// Policy Pages Routes
Route::prefix('policies')->name('policies.')->group(function () {
    Route::get('/privacy', [PolicyController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PolicyController::class, 'terms'])->name('terms');
    Route::get('/shipping', [PolicyController::class, 'shipping'])->name('shipping');
    Route::get('/refund', [PolicyController::class, 'refund'])->name('refund');
    Route::get('/cookies', [PolicyController::class, 'cookies'])->name('cookies');
});

// ============================================================================
// CHECKOUT & ORDER MANAGEMENT ROUTES
// ============================================================================

// Public Order Tracking (without authentication)
Route::get('/track-order', [CheckoutController::class, 'track'])->name('track.order');

// Checkout Routes - Require Authentication
Route::middleware('auth')->group(function () {
    // Checkout Process
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
        
        // Order Management
        Route::get('/order/{order}', [CheckoutController::class, 'orderDetails'])->name('order.details');
        Route::get('/download-invoice/{order}', [CheckoutController::class, 'downloadInvoice'])->name('download.invoice');
        Route::delete('/cancel/{order}', [CheckoutController::class, 'cancel'])->name('cancel');
    });
});

// ============================================================================
// ADMIN ROUTES
// ============================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Order Management Routes
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [AdminController::class, 'orderDetails'])->name('orders.show');
    Route::get('/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('orders.edit');
    Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');
    Route::delete('/orders/{id}', [AdminController::class, 'destroyOrder'])->name('orders.destroy');
    Route::get('/orders/{id}/print', [AdminController::class, 'printOrder'])->name('orders.print');
    Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('orders.export');
    Route::post('/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::post('/orders/{id}/update-tracking', [AdminController::class, 'updateTracking'])->name('orders.update-tracking');
    Route::get('/orders/{id}/invoice', [AdminController::class, 'generateInvoice'])->name('orders.invoice');

    // Product Management Routes
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}', [AdminController::class, 'showProduct'])->name('products.show');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::patch('/products/{id}/toggle-status', [AdminController::class, 'toggleProductStatus'])->name('products.toggle-status');
    Route::patch('/products/{id}/toggle-featured', [AdminController::class, 'toggleProductFeatured'])->name('products.toggle-featured');
    Route::post('/products/import', [AdminController::class, 'importProducts'])->name('products.import');
    Route::get('/products/export', [AdminController::class, 'exportProducts'])->name('products.export');
    Route::post('/products/{id}/upload-images', [AdminController::class, 'uploadProductImages'])->name('products.upload-images');

    // Category Management Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Customer Management Routes
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers.index');
    Route::get('/customers/{id}', [AdminController::class, 'showCustomer'])->name('customers.show');
    Route::get('/customers/{id}/edit', [AdminController::class, 'editCustomer'])->name('customers.edit');
    Route::put('/customers/{id}', [AdminController::class, 'updateCustomer'])->name('customers.update');
    Route::patch('/customers/{id}/toggle-status', [AdminController::class, 'toggleCustomerStatus'])->name('customers.toggle-status');
    Route::delete('/customers/{id}', [AdminController::class, 'destroyCustomer'])->name('customers.destroy');
    Route::get('/customers/export', [AdminController::class, 'exportCustomers'])->name('customers.export');
    Route::get('/customers/{id}/orders', [AdminController::class, 'customerOrders'])->name('customers.orders');

    // User Management Routes
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Blog Management Routes
    Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs.index');
    Route::get('/blogs/create', [AdminController::class, 'createBlog'])->name('blogs.create');
    Route::post('/blogs', [AdminController::class, 'storeBlog'])->name('blogs.store');
    Route::get('/blogs/{id}', [AdminController::class, 'showBlog'])->name('blogs.show');
    Route::get('/blogs/{id}/edit', [AdminController::class, 'editBlog'])->name('blogs.edit');
    Route::put('/blogs/{id}', [AdminController::class, 'updateBlog'])->name('blogs.update');
    Route::patch('/blogs/{id}/toggle-publish', [AdminController::class, 'toggleBlogPublish'])->name('blogs.toggle-publish');
    Route::delete('/blogs/{id}', [AdminController::class, 'destroyBlog'])->name('blogs.destroy');

    // Feedback Management Routes
    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback.index');
    Route::get('/feedback/create', [AdminController::class, 'createFeedback'])->name('feedback.create');
    Route::post('/feedback', [AdminController::class, 'storeFeedback'])->name('feedback.store');
    Route::get('/feedback/{id}', [AdminController::class, 'showFeedback'])->name('feedback.show');
    Route::get('/feedback/{id}/edit', [AdminController::class, 'editFeedback'])->name('feedback.edit');
    Route::put('/feedback/{id}', [AdminController::class, 'updateFeedback'])->name('feedback.update');
    Route::delete('/feedback/{id}', [AdminController::class, 'destroyFeedback'])->name('feedback.destroy');
    Route::get('/feedback/export', [AdminController::class, 'exportFeedback'])->name('feedback.export');

    // Reviews Management Routes
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::put('/reviews/{id}/approve', [AdminController::class, 'approveReview'])->name('reviews.approve');
    Route::put('/reviews/{id}/reject', [AdminController::class, 'rejectReview'])->name('reviews.reject');
    Route::delete('/reviews/{id}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');

    // Coupon Management Routes
    Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons.index');
    Route::get('/coupons/create', [AdminController::class, 'createCoupon'])->name('coupons.create');
    Route::post('/coupons', [AdminController::class, 'storeCoupon'])->name('coupons.store');
    Route::get('/coupons/{id}', [AdminController::class, 'showCoupon'])->name('coupons.show');
    Route::get('/coupons/{id}/edit', [AdminController::class, 'editCoupon'])->name('coupons.edit');
    Route::put('/coupons/{id}', [AdminController::class, 'updateCoupon'])->name('coupons.update');
    Route::patch('/coupons/{id}/toggle-status', [AdminController::class, 'toggleCouponStatus'])->name('coupons.toggle-status');
    Route::delete('/coupons/{id}', [AdminController::class, 'destroyCoupon'])->name('coupons.destroy');
    Route::get('/coupons/validate/{code}', [AdminController::class, 'validateCoupon'])->name('coupons.validate');

    // Banner Management Routes
    Route::get('/banners', [AdminController::class, 'banners'])->name('banners.index');
    Route::get('/banners/create', [AdminController::class, 'createBanner'])->name('banners.create');
    Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
    Route::get('/banners/{id}', [AdminController::class, 'showBanner'])->name('banners.show');
    Route::get('/banners/{id}/edit', [AdminController::class, 'editBanner'])->name('banners.edit');
    Route::put('/banners/{id}', [AdminController::class, 'updateBanner'])->name('banners.update');
    Route::delete('/banners/{id}', [AdminController::class, 'destroyBanner'])->name('banners.destroy');

    // Announcement Management Routes
    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements.index');
    Route::get('/announcements/create', [AdminController::class, 'createAnnouncement'])->name('announcements.create');
    Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::get('/announcements/{id}', [AdminController::class, 'showAnnouncement'])->name('announcements.show');
    Route::get('/announcements/{id}/edit', [AdminController::class, 'editAnnouncement'])->name('announcements.edit');
    Route::put('/announcements/{id}', [AdminController::class, 'updateAnnouncement'])->name('announcements.update');
    Route::delete('/announcements/{id}', [AdminController::class, 'destroyAnnouncement'])->name('announcements.destroy');

    // Reports Management Routes
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::get('/reports/sales', [AdminController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/customers', [AdminController::class, 'customersReport'])->name('reports.customers');
    Route::get('/reports/products', [AdminController::class, 'productsReport'])->name('reports.products');
    Route::get('/reports/export/{type}', [AdminController::class, 'exportReport'])->name('reports.export');
    Route::get('/reports/dashboard', [AdminController::class, 'dashboardReport'])->name('reports.dashboard');

    // Settings Routes
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/settings/general', [AdminController::class, 'updateGeneralSettings'])->name('settings.general.update');
    Route::post('/settings/email', [AdminController::class, 'updateEmailSettings'])->name('settings.email.update');
    Route::post('/settings/payment', [AdminController::class, 'updatePaymentSettings'])->name('settings.payment.update');
    Route::post('/settings/maintenance', [AdminController::class, 'updateMaintenanceSettings'])->name('settings.maintenance.update');

    // Additional settings utility routes
    Route::get('/settings/backup', [AdminController::class, 'backupDatabase'])->name('settings.backup');
    Route::get('/settings/cache/clear', [AdminController::class, 'clearCache'])->name('settings.cache.clear');
    Route::post('/settings/email/test', [AdminController::class, 'testEmail'])->name('settings.email.test');
    Route::get('/settings/logs', [AdminController::class, 'viewLogs'])->name('settings.logs');
    Route::get('/settings/activity', [AdminController::class, 'activityLog'])->name('settings.activity');

    // ============================================================================
    // ADMIN PROFILE ROUTES
    // ============================================================================
    
    // Profile Routes (Updated with proper naming)
    Route::get('/profile', [AdminController::class, 'adminProfile'])->name('profile.index');
    Route::put('/profile', [AdminController::class, 'updateAdminProfile'])->name('profile.update');
    Route::get('/profile/change-password', [AdminController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [AdminController::class, 'changePassword'])->name('profile.update-password');
    
    // Admin Notifications
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/mark-read', [AdminController::class, 'markNotificationsRead'])->name('notifications.mark-read');
    Route::post('/notifications/clear', [AdminController::class, 'clearNotifications'])->name('notifications.clear');
    
    // Admin Dashboard Widgets
    Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats'])->name('dashboard.stats');
    Route::get('/dashboard/charts', [AdminController::class, 'dashboardCharts'])->name('dashboard.charts');
    Route::get('/dashboard/activity', [AdminController::class, 'dashboardActivity'])->name('dashboard.activity');
});

// ============================================================================
// API ROUTES FOR AJAX REQUESTS
// ============================================================================

Route::prefix('api')->name('api.')->group(function () {
    // Public APIs
    Route::get('/products/search', [ShopController::class, 'search'])->name('products.search');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/product/{id}/quick-view', [ShopController::class, 'quickView'])->name('product.quick-view');
    
    // Protected APIs (require authentication)
    Route::middleware('auth')->group(function () {
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');
    });
});

// ============================================================================
// STATIC PAGES & MISCELLANEOUS ROUTES
// ============================================================================

Route::get('/sitemap.xml', function() {
    return response()->view('sitemap')->header('Content-Type', 'text/xml');
})->name('sitemap');

Route::get('/robots.txt', function() {
    return response()->view('robots')->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/health', function() {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
})->name('health');

// ============================================================================
// FALLBACK ROUTE FOR 404
// ============================================================================

Route::fallback(function () {
    return view('errors.404', [
        'title' => 'Page Not Found - Ghazali Food',
        'message' => 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.'
    ]);
});