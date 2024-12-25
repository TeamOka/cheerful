<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', function () {
//     return view('home');
// })->middleware(['auth', 'verified'])->name('home');

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // プロダクトのルーティング
    Route::resource('products', ProductController::class);
    Route::get('mylist', [ProductController::class, 'mylist'])->name('products.mylist');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/destroy/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 応援のルーティング
    Route::post('/products/{product}/cheer', [ProductContactController::class, 'store'])->name('products.cheer');
    Route::delete('/products/{product}/cheer', [ProductContactController::class, 'destroy'])->name('products.discheer');
});

require __DIR__ . '/auth.php';
