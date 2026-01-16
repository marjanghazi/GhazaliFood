<?php

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

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/categories', [ShopController::class, 'categories'])->name('categories.index');

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
Route::prefix('wishlist')->name('wishlist.')->middleware('auth')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
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
Route::prefix('policies')->name('policies.')->group(function () {
    Route::get('/privacy', [PolicyController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PolicyController::class, 'terms'])->name('terms');
    Route::get('/shipping', [PolicyController::class, 'shipping'])->name('shipping');
    Route::get('/refund', [PolicyController::class, 'refund'])->name('refund');
    Route::get('/cookies', [PolicyController::class, 'cookies'])->name('cookies');
});
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.edit');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/orders', [AuthController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [AuthController::class, 'orderDetails'])->name('orders.show');
});

// Policy Pages Routes
Route::prefix('policies')->name('policies.')->group(function () {
    Route::get('/privacy', [PolicyController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PolicyController::class, 'terms'])->name('terms');
    Route::get('/shipping', [PolicyController::class, 'shipping'])->name('shipping');
    Route::get('/refund', [PolicyController::class, 'refund'])->name('refund');
    Route::get('/cookies', [PolicyController::class, 'cookies'])->name('cookies');
});

// Checkout Route (temporary)
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Add more admin routes here
});

// Fallback Route for 404
Route::fallback(function () {
    return view('errors.404');
});