<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // プロダクトのルーティング
    Route::resource('products', ProductController::class);
    Route::get('/products/mylist', [ProductController::class, 'mylist'])->name('products.mylist');
    Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__ . '/auth.php';
