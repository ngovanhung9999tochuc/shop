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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckOut;

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
//home
Route::get('/', [HomeController::class, 'getHome'])->name('home');
Route::get('/type/{type}/{id}', [HomeController::class, 'getPageTypeProduct'])->name('typeproduct');
Route::get('/type/{id}', [HomeController::class, 'getTypeProduct'])->name('type.type');
Route::get('/detail/{id}', [HomeController::class, 'getProductDetail'])->name('detail');
Route::get('/order', [HomeController::class, 'getOrder'])->name('order')->middleware(CheckOut::class);
Route::post('/order/enter', [HomeController::class, 'enterAnOrder'])->name('order.enter');
//login
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/test', [LoginController::class, 'test'])->name('test');
//register
Route::post('/cart/add', [CartController::class, 'addItemToCart'])->name('cart.add');
Route::post('/cart/change', [CartController::class, 'changeQuantityItemToCart'])->name('cart.change');
Route::post('/cart/delete', [CartController::class, 'deleteItemToCart'])->name('cart.delete');

Route::middleware('can:admin')->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    //product

    Route::middleware('can:product')->group(function () {
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');
        Route::get('/product/price/{product}', [ProductController::class, 'getPrice'])->name('product.price');
        Route::post('/product/price/{product}', [ProductController::class, 'setPrice'])->name('product.price');
    });

    Route::middleware('can:producttype')->group(function () {
        Route::post('/producttype/parent', [ProductTypeController::class, 'getParent'])->name('producttype.parent');
        Route::get('/producttype', [ProductTypeController::class, 'index'])->name('producttype.index');
        Route::post('/producttype/store', [ProductTypeController::class, 'store'])->name('producttype.store');
        Route::post('/producttype/edit', [ProductTypeController::class, 'edit'])->name('producttype.edit');
        Route::post('/producttype/update', [ProductTypeController::class, 'update'])->name('producttype.update');
        Route::delete('/producttype/{producttype}', [ProductTypeController::class, 'destroy'])->name('producttype.destroy');
        Route::post('/producttype/search', [ProductTypeController::class, 'search'])->name('producttype.search');
    });

    Route::middleware('can:supplier')->group(function () {
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::post('/supplier/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::post('/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');
    });

    //bill in
    Route::middleware('can:billin')->group(function () {
        Route::post('/billin/supplier', [BillInController::class, 'getSuppliers'])->name('billin.supplier');
        Route::post('/billin/products', [BillInController::class, 'searchProducts'])->name('billin.products');
        Route::get('/billin', [BillInController::class, 'index'])->name('billin.index');
        Route::get('/billin/create', [BillInController::class, 'create'])->name('billin.create');
        Route::post('/billin', [BillInController::class, 'store'])->name('billin.store');
        Route::post('/billin/show', [BillInController::class, 'show'])->name('billin.show');
        Route::delete('/billin/{billin}', [BillInController::class, 'destroy'])->name('billin.destroy');
        Route::post('/billin/search', [BillInController::class, 'search'])->name('billin.search');
    });

    //user
    Route::middleware('can:user')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::post('/user/show', [UserController::class, 'show'])->name('user.show');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('/user/search', [UserController::class, 'search'])->name('user.search');
        Route::post('/user/role', [UserController::class, 'updateRole'])->name('user.role');
    });
    //bill
    Route::middleware('can:bill')->group(function () {
        Route::get('/bill', [BillController::class, 'index'])->name('bill.index');
        Route::post('/bill/show', [BillController::class, 'show'])->name('bill.show');
        Route::delete('/bill/{bill}', [BillController::class, 'destroy'])->name('bill.destroy');
        Route::post('/bill/search', [BillController::class, 'search'])->name('bill.search');
        Route::post('/bill/status', [BillController::class, 'changeStatus'])->name('bill.status');
        Route::post('/bill/search/status', [BillController::class, 'searchStatus'])->name('bill.search.status');
    });
    //archive
    Route::middleware('can:archive')->group(function () {
        Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
        Route::post('/archive/search', [ArchiveController::class, 'search'])->name('archive.search');
        Route::post('/archive/producttype', [ArchiveController::class, 'searchProductType'])->name('archive.producttype');
    });

    //slide
    Route::middleware('can:slide')->group(function () {
        Route::get('/slide', [SlideController::class, 'index'])->name('slide.index');
        Route::post('/slide/store', [SlideController::class, 'store'])->name('slide.store');
        Route::post('/slide/edit', [SlideController::class, 'edit'])->name('slide.edit');
        Route::post('/slide/update', [SlideController::class, 'update'])->name('slide.update');
        Route::delete('/slide/{slide}', [SlideController::class, 'destroy'])->name('slide.destroy');
        Route::post('/slide/search', [SlideController::class, 'search'])->name('slide.search');
    });
    //menu
    Route::middleware('can:menu')->group(function () {
        Route::post('/menu/parent', [MenuController::class, 'getParent'])->name('menu.parent');
        Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
        Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
        Route::post('/menu/edit', [MenuController::class, 'edit'])->name('menu.edit');
        Route::post('/menu/update', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::post('/menu/search', [MenuController::class, 'search'])->name('menu.search');
    });
    //role
    Route::middleware('can:role')->group(function () {
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');
        Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
        Route::post('/role/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/role/update', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
        Route::post('/role/search', [RoleController::class, 'search'])->name('role.search');
        Route::post('/role/permission', [RoleController::class, 'getListPermission'])->name('role.permission');
        Route::post('/role/permission/update', [RoleController::class, 'updateListPermission'])->name('role.permission');
    });
});
