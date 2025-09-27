<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('landing-page');
});

Route::get('/dashboard', function () {
    return view('dashboard');
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

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function(){
    Route::resource('menus', MenuController::class)->middleware('can:admin-only');
   // Route::resource('categories', CategoryController::class)->middleware('can:admin-only');
    Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/order', [OrderController::class,'store'])->name('order.store');
    Route::post('/midtrans/notification', [PaymentController::class,'notification']);
    Route::resource('reviews', ReviewController::class)->only(['store','destroy','index']);
});


