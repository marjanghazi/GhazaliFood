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
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    
    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/{order}/print', [OrderController::class, 'printInvoice'])->name('orders.print');
    Route::get('/orders/export/csv', [OrderController::class, 'export'])->name('orders.export');
    
    // Customers
    Route::resource('customers', CustomerController::class);
    Route::post('/customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    Route::get('/customers/export/csv', [CustomerController::class, 'export'])->name('customers.export');
    
    // Coupons
    Route::resource('coupons', CouponController::class);
    Route::post('/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
    Route::get('/coupons/generate/code', [CouponController::class, 'generateCode'])->name('coupons.generate-code');
    
    // Banners
    Route::resource('banners', BannerController::class);
    
    // Announcements
    Route::resource('announcements', AnnouncementController::class);
    
    // Blogs
    Route::resource('blogs', BlogController::class);
    Route::post('/blogs/{blog}/toggle-publish', [BlogController::class, 'togglePublish'])->name('blogs.toggle-publish');
    
    // Feedback/Support
    Route::resource('feedback', FeedbackController::class)->except(['create', 'store']);
    Route::post('/feedback/{feedback}/update-status', [FeedbackController::class, 'updateStatus'])->name('feedback.update-status');
    Route::post('/feedback/{feedback}/respond', [FeedbackController::class, 'respond'])->name('feedback.respond');
    Route::get('/feedback/export/csv', [FeedbackController::class, 'export'])->name('feedback.export');
    
    // Reviews
    Route::resource('reviews', ReviewController::class);
    Route::post('/reviews/{review}/update-status', [ReviewController::class, 'updateStatus'])->name('reviews.update-status');
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/products', [ReportController::class, 'products'])->name('products');
        Route::get('/customers', [ReportController::class, 'customers'])->name('customers');
        Route::get('/coupons', [ReportController::class, 'coupons'])->name('coupons');
        Route::get('/export/sales', [ReportController::class, 'exportSales'])->name('export-sales');
    });
    
    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/general/update', [SettingController::class, 'updateGeneral'])->name('general.update');
        Route::post('/email/update', [SettingController::class, 'updateEmail'])->name('email.update');
        Route::post('/payment/update', [SettingController::class, 'updatePayment'])->name('payment.update');
        Route::get('/backup/database', [SettingController::class, 'backupDatabase'])->name('backup');
        Route::get('/clear/cache', [SettingController::class, 'clearCache'])->name('cache.clear');
    });
});