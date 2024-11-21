<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('shop.index');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/add-product', function () {
    return view('add-product');
})->name('add-product');
Route::post('/add-product', [ProductController::class, 'store'])->name('product.store');
Route::get('/{id}/update-product', [ProductController::class, 'update'])->name('update-product');

Route::put('/{id}/update-product', [ProductController::class, 'updateProduct'])->name('update-product');

Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');