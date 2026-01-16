<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    ProductController,
    CategoryController,
    OrderController,
    CustomerController,
    CouponController,
    BannerController,
    AnnouncementController,
    BlogController,
    FeedbackController,
    ReviewController,
    ReportController,
    SettingController
};
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Customers
    Route::resource('customers', CustomerController::class);
    Route::post('/customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    
    // Coupons
    Route::resource('coupons', CouponController::class);
    Route::post('/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
    
    // Banners
    Route::resource('banners', BannerController::class);
    
    // Announcements
    Route::resource('announcements', AnnouncementController::class);
    
    // Blogs
    Route::resource('blogs', BlogController::class);
    Route::post('/blogs/{blog}/toggle-publish', [BlogController::class, 'togglePublish'])->name('blogs.toggle-publish');
    
    // Feedback/Support
    Route::resource('feedback', FeedbackController::class);
    Route::post('/feedback/{feedback}/update-status', [FeedbackController::class, 'updateStatus'])->name('feedback.update-status');
    Route::post('/feedback/{feedback}/respond', [FeedbackController::class, 'respond'])->name('feedback.respond');
    
    // Reviews
    Route::resource('reviews', ReviewController::class);
    Route::post('/reviews/{review}/update-status', [ReviewController::class, 'updateStatus'])->name('reviews.update-status');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general');
    Route::post('/settings/email', [SettingController::class, 'updateEmail'])->name('settings.email');
    Route::post('/settings/payment', [SettingController::class, 'updatePayment'])->name('settings.payment');
});