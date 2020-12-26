<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BillInController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillController;
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
    //Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    //Route::get('/supplier/{supplier}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::post('/supplier/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::post('/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');
    //bill in
    Route::post('/billin/supplier', [BillInController::class, 'getSuppliers'])->name('billin.supplier');
    Route::post('/billin/products', [BillInController::class, 'searchProducts'])->name('billin.products');
    Route::get('/billin', [BillInController::class, 'index'])->name('billin.index');
    Route::get('/billin/create', [BillInController::class, 'create'])->name('billin.create');
    Route::post('/billin', [BillInController::class, 'store'])->name('billin.store');
    Route::get('/billin/{billin}', [BillInController::class, 'show'])->name('billin.show');
    //Route::get('/billin/{billin}/edit', [BillInController::class, 'edit'])->name('billin.edit');
    //Route::put('/billin/{billin}', [BillInController::class, 'update'])->name('billin.update');
    Route::delete('/billin/{billin}', [BillInController::class, 'destroy'])->name('billin.destroy');
    Route::post('/billin/search', [BillInController::class, 'search'])->name('billin.search');


    //user
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/show', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/user/search', [UserController::class, 'search'])->name('user.search');
    Route::post('/user/role', [UserController::class, 'updateRole'])->name('user.role');

    Route::get('/bill', [BillController::class, 'index'])->name('bill.index');
    Route::get('/bill/create', [BillController::class, 'create'])->name('bill.create');
    Route::post('/bill', [BillController::class, 'store'])->name('bill.store');
    Route::post('/bill/show', [BillController::class, 'show'])->name('bill.show');
    Route::get('/bill/{bill}/edit', [BillController::class, 'edit'])->name('bill.edit');
    Route::put('/bill/{bill}', [BillController::class, 'update'])->name('bill.update');
    Route::delete('/bill/{bill}', [BillController::class, 'destroy'])->name('bill.destroy');
    Route::post('/bill/search', [BillController::class, 'search'])->name('bill.search');
    Route::post('/bill/status', [BillController::class, 'changeStatus'])->name('bill.status');
    Route::post('/bill/search/status', [BillController::class, 'searchStatus'])->name('bill.search.status');

});
