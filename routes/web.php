<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BillInController;
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
    //Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');
    Route::get('/product/price/{product}', [ProductController::class, 'getPrice'])->name('product.price');
    Route::post('/product/price/{product}', [ProductController::class, 'setPrice'])->name('product.price');

    Route::get('/producttype', [ProductTypeController::class, 'index'])->name('producttype.index');
    Route::get('/producttype/create', [ProductTypeController::class, 'create'])->name('producttype.create');
    Route::post('/producttype', [ProductTypeController::class, 'store'])->name('producttype.store');
    //Route::get('/producttype/{producttype}', [ProductTypeController::class, 'show'])->name('producttype.show');
    Route::get('/producttype/{producttype}/edit', [ProductTypeController::class, 'edit'])->name('producttype.edit');
    Route::put('/producttype/{producttype}', [ProductTypeController::class, 'update'])->name('producttype.update');
    Route::delete('/producttype/{producttype}', [ProductTypeController::class, 'destroy'])->name('producttype.destroy');
    Route::post('/producttype/search', [ProductTypeController::class, 'search'])->name('producttype.search');


    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    //Route::get('/supplier/{supplier}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::post('/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');

    Route::post('/billin/products', [BillInController::class, 'searchProducts'])->name('billin.products');
    Route::get('/billin', [BillInController::class, 'index'])->name('billin.index');
    Route::get('/billin/create', [BillInController::class, 'create'])->name('billin.create');
    Route::post('/billin', [BillInController::class, 'store'])->name('billin.store');
    Route::get('/billin/{billin}', [BillInController::class, 'show'])->name('billin.show');
    //Route::get('/billin/{billin}/edit', [BillInController::class, 'edit'])->name('billin.edit');
    //Route::put('/billin/{billin}', [BillInController::class, 'update'])->name('billin.update');
    Route::delete('/billin/{billin}', [BillInController::class, 'destroy'])->name('billin.destroy');
    Route::post('/billin/search', [BillInController::class, 'search'])->name('billin.search');
    
});
