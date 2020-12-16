<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('back_end.admin.admin');
});

Route::prefix('admin')->group(function () {

    //product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');
    Route::get('/product/price/{product}', [ProductController::class, 'getPrice'])->name('product.price');
    Route::post('/product/price/{product}', [ProductController::class, 'setPrice'])->name('product.price');

    Route::get('/producttype', [ProductTypeController::class, 'index'])->name('producttype.index');
    Route::get('/producttype/create', [ProductTypeController::class, 'create'])->name('producttype.create');
    Route::post('/producttype', [ProductTypeController::class, 'store'])->name('producttype.store');
    Route::get('/producttype/{producttype}', [ProductTypeController::class, 'show'])->name('producttype.show');
    Route::get('/producttype/{producttype}/edit', [ProductTypeController::class, 'edit'])->name('producttype.edit');
    Route::put('/producttype/{producttype}', [ProductTypeController::class, 'update'])->name('producttype.update');
    Route::delete('/producttype/{producttype}', [ProductTypeController::class, 'destroy'])->name('producttype.destroy');
    Route::post('/producttype/search', [ProductTypeController::class, 'search'])->name('producttype.search');
});
