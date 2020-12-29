<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BillInController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
/*
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

    // Route::get('/producttype', [ProductTypeController::class, 'index'])->name('producttype.index');
    // Route::get('/producttype/create', [ProductTypeController::class, 'create'])->name('producttype.create');
    // Route::post('/producttype', [ProductTypeController::class, 'store'])->name('producttype.store');
    // Route::get('/producttype/{producttype}', [ProductTypeController::class, 'show'])->name('producttype.show');
    // Route::get('/producttype/{producttype}/edit', [ProductTypeController::class, 'edit'])->name('producttype.edit');
    // Route::put('/producttype/{producttype}', [ProductTypeController::class, 'update'])->name('producttype.update');
    // Route::delete('/producttype/{producttype}', [ProductTypeController::class, 'destroy'])->name('producttype.destroy');
    // Route::post('/producttype/search', [ProductTypeController::class, 'search'])->name('producttype.search');

    Route::post('/producttype/parent', [ProductTypeController::class, 'getParent'])->name('producttype.parent');
    Route::get('/producttype', [ProductTypeController::class, 'index'])->name('producttype.index');
    //Route::get('/producttype/create', [ProductTypeController::class, 'create'])->name('producttype.create');
    Route::post('/producttype/store', [ProductTypeController::class, 'store'])->name('producttype.store');
    //Route::get('/producttype/{producttype}', [ProductTypeController::class, 'show'])->name('producttype.show');
    Route::post('/producttype/edit', [ProductTypeController::class, 'edit'])->name('producttype.edit');
    Route::post('/producttype/update', [ProductTypeController::class, 'update'])->name('producttype.update');
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
    Route::post('/billin/show', [BillInController::class, 'show'])->name('billin.show');
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
    //bill
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

    //archive
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
    // Route::get('/archive/create', [ArchiveController::class, 'create'])->name('archive.create');
    // Route::post('/archive', [ArchiveController::class, 'store'])->name('archive.store');
    // Route::get('/archive/{archive}', [ArchiveController::class, 'show'])->name('archive.show');
    // Route::get('/archive/{archive}/edit', [ArchiveController::class, 'edit'])->name('archive.edit');
    // Route::put('/archive/{archive}', [ArchiveController::class, 'update'])->name('archive.update');
    // Route::delete('/archive/{archive}', [ArchiveController::class, 'destroy'])->name('archive.destroy');
    Route::post('/archive/search', [ArchiveController::class, 'search'])->name('archive.search');
    Route::post('/archive/producttype', [ArchiveController::class, 'searchProductType'])->name('archive.producttype');


    //slide

    Route::get('/slide', [SlideController::class, 'index'])->name('slide.index');
    //Route::get('/slide/create', [SlideController::class, 'create'])->name('slide.create');
    Route::post('/slide/store', [SlideController::class, 'store'])->name('slide.store');
    //Route::get('/slide/{slide}', [SlideController::class, 'show'])->name('slide.show');
    Route::post('/slide/edit', [SlideController::class, 'edit'])->name('slide.edit');
    Route::post('/slide/update', [SlideController::class, 'update'])->name('slide.update');
    Route::delete('/slide/{slide}', [SlideController::class, 'destroy'])->name('slide.destroy');
    Route::post('/slide/search', [SlideController::class, 'search'])->name('slide.search');

    //menu
    Route::post('/menu/parent', [MenuController::class, 'getParent'])->name('menu.parent');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    //Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    //Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');
    Route::post('/menu/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::post('/menu/update', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::post('/menu/search', [MenuController::class, 'search'])->name('menu.search');

    //role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::post('/role/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/role/update', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::post('/role/search', [RoleController::class, 'search'])->name('role.search');
});
