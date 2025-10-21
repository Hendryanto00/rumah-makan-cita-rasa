<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('landing-page');
});

Route::get('/dashboard', function () {
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

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function(){
    // Admin routes
    Route::middleware('can:admin-only')->group(function(){
        Route::resource('menus', AdminMenuController::class);
        Route::resource('categories', CategoryController::class);
        Route::prefix('admin')->name('admin.')->group(function(){
            Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
            Route::get('/reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
            Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
            Route::patch('/reviews/{review}/hide', [AdminReviewController::class, 'hide'])->name('reviews.hide');
            Route::delete('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
            Route::post('/reviews/bulk-action', [AdminReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
            Route::get('/reviews-statistics', [AdminReviewController::class, 'statistics'])->name('reviews.statistics');
        });
    });
    
    // User routes - require email verification
    Route::middleware('verified')->group(function(){
        Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
        Route::get('/cart', [CartController::class,'index'])->name('cart.index');
        Route::post('/order', [OrderController::class,'store'])->name('order.store');
        Route::post('/midtrans/notification', [PaymentController::class,'notification']);
        
        // Review routes (exclude index and edit)
        Route::resource('reviews', ReviewController::class)->except(['index', 'edit']);
        Route::get('/menus/{menu}/reviews', [ReviewController::class, 'getMenuReviews'])->name('menus.reviews');
    });
});


