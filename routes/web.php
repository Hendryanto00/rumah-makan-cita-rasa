<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\RealtimeController;

Route::get('/', function () {
    return view('landing-page');
});

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect('/');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

// Public menu routes
Route::get('/menu', [MenuController::class, 'index'])->name('menus.index');
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menus.show');

// Real-time API endpoints
Route::prefix('api')->group(function(){
    Route::get('/menu-updates', [RealtimeController::class, 'getMenuUpdates'])->name('api.menu-updates');
    Route::get('/new-orders', [RealtimeController::class, 'getNewOrders'])->name('api.new-orders');
    Route::get('/orders-count', [RealtimeController::class, 'getOrdersCount'])->name('api.orders-count');
    Route::get('/review-updates', [RealtimeController::class, 'getReviewUpdates'])->name('api.review-updates');
});

require __DIR__.'/auth.php';

// Midtrans notification endpoint - must be public and excluded from CSRF
// Allow both GET (for health checks) and POST (for notifications)
Route::match(['get', 'post'], '/midtrans/notification', [PaymentController::class,'notification']);

Route::middleware(['auth'])->group(function(){
    // Admin routes
    Route::middleware('can:admin-only')->group(function(){
        Route::prefix('admin')->name('admin.')->group(function(){
            Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
            
            // Halaman profil admin kustom
            Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile');
            Route::patch('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
            
            Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
            Route::get('/reviews/statistics', [AdminReviewController::class, 'statisticsPage'])->name('reviews.statistics');
            Route::get('/reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
            Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
            Route::patch('/reviews/{review}/hide', [AdminReviewController::class, 'hide'])->name('reviews.hide');
            Route::patch('/reviews/{review}/unhide', [AdminReviewController::class, 'unhide'])->name('reviews.unhide');
            Route::delete('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
            Route::post('/reviews/bulk-action', [AdminReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
            Route::get('/reviews-statistics-api', [AdminReviewController::class, 'statistics'])->name('reviews.statistics.api');

            // Admin resource routes
            Route::resource('menus', AdminMenuController::class);
            Route::resource('categories', CategoryController::class);
            
            // Admin orders routes
            Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
            Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
            
            // Admin can download invoice for any order
            Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
        });
    });
    
    // User routes - require email verification
    Route::middleware('verified')->group(function(){
        Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
        Route::get('/cart', [CartController::class,'index'])->name('cart.index');
        Route::post('/cart/update/{item}', [CartController::class,'update'])->name('cart.update');
        Route::delete('/cart/remove/{item}', [CartController::class,'remove'])->name('cart.remove');
        Route::delete('/cart/clear', [CartController::class,'clear'])->name('cart.clear');
        Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class,'show'])->name('orders.show');
        Route::post('/order', [OrderController::class,'store'])->name('order.store');
        Route::get('/order/{order}/continue-payment', [OrderController::class,'continuePayment'])->name('order.continue-payment');
        Route::get('/order/{order}/invoice', [OrderController::class,'downloadInvoice'])->name('order.invoice');
        Route::get('/payment/snap', function(Request $request) {
            $order = \App\Models\Order::with(['details.menu'])->findOrFail($request->order);
            return view('payment.snap', [
                'snapToken' => $request->token,
                'order' => $order
            ]);
        })->name('payment.snap');
        
        // Review routes (exclude edit and index)
        Route::resource('reviews', ReviewController::class)->except(['edit', 'index']);
        Route::get('/menus/{menu}/reviews', [ReviewController::class, 'getMenuReviews'])->name('menus.reviews');
    });
});


