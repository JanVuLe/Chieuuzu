<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ShopLoginController;
use App\Http\Controllers\Auth\ShopRegisterController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\ContactController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\LocationController;
use Illuminate\Support\Facades\Route;


//ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('/login/store', [AdminLoginController::class, 'store'])->name('admin.login.store');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        //Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        //Users
        Route::resource('/users', UserController::class)->names([
            'index'   => 'admin.users.index',
            'create'  => 'admin.users.create',
            'store'   => 'admin.users.store',
            'show'    => 'admin.users.show',
            'edit'    => 'admin.users.edit',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy'
        ]);
        Route::post('/users/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        //Categories
        Route::resource('/categories', CategoryController::class)->parameters(['categories' => 'slug'])->names([
            'index'   => 'admin.categories.index',
            'create'  => 'admin.categories.create',
            'store'   => 'admin.categories.store',
            'edit'    => 'admin.categories.edit',
            'update'  => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy'
        ]);
        //Discounts
        Route::resource('/discounts', DiscountController::class)->parameters(['discounts' => 'slug'])->names([
            'index'   => 'admin.discounts.index',
            'create'  => 'admin.discounts.create',
            'store'   => 'admin.discounts.store',
            'edit'    => 'admin.discounts.edit',
            'update'  => 'admin.discounts.update',
            'destroy' => 'admin.discounts.destroy'
        ]);
        //Products
        Route::resource('/products', ProductController::class)->parameters(['products' => 'slug'])->names([
            'index'   => 'admin.products.index',
            'create'  => 'admin.products.create',
            'store'   => 'admin.products.store',
            'show'    => 'admin.products.show',
            'edit'    => 'admin.products.edit',
            'update'  => 'admin.products.update',
            'destroy' => 'admin.products.destroy'
        ]);
        Route::post('/products/apply-discount', [ProductController::class, 'applyDiscount'])->name('admin.products.applyDiscount');
        Route::delete('/products/{product}/discounts/{discount}', [ProductController::class, 'removeDiscount'])->name('admin.products.removeDiscount');
        Route::delete('/product-images/{id}', [ProductImageController::class, 'destroy'])->name('admin.product_images.destroy');
        //Warehouses
        Route::resource('/warehouses', WarehouseController::class)->names([
            'index'   => 'admin.warehouses.index',
            'create'  => 'admin.warehouses.create',
            'store'   => 'admin.warehouses.store',
            'show'    => 'admin.warehouses.show',
            'edit'    => 'admin.warehouses.edit',
            'update'  => 'admin.warehouses.update',
            'destroy' => 'admin.warehouses.destroy'
        ]);
        //Orders
        Route::resource('/orders', OrderController::class)->names([
            'index'   => 'admin.orders.index',
            'create'  => 'admin.orders.create',
            'store'   => 'admin.orders.store',
            'show'    => 'admin.orders.show',
            'edit'    => 'admin.orders.edit',
            'update'  => 'admin.orders.update',
            'destroy' => 'admin.orders.destroy'
        ]);
        Route::post('/warehouses/{id}/add-product', [WarehouseController::class, 'addProduct'])->name('admin.warehouses.addProduct');
        Route::delete('/warehouses/{warehouseId}/remove-product/{productId}', [WarehouseController::class, 'removeProduct'])->name('admin.warehouses.removeProduct');
        //Profile
        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('admin.profile');
    });
});

//SHOP
//Login logout
Route::get('/login', [ShopLoginController::class, 'showLoginForm'])->name('shop.login');
Route::post('/login/store', [ShopLoginController::class, 'store'])->name('shop.login.store');
Route::post('/logout', [ShopLoginController::class, 'logout'])->name('logout');
Route::get('/register', [ShopRegisterController::class, 'showRegisterForm'])->name('shop.register');
Route::post('/register', [ShopRegisterController::class, 'register'])->name('shop.register.store');
//Home
Route::get('/', [ShopController::class, 'index'])->name('shop.home');
Route::get('/category/{id}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/contact', [ShopController::class, 'contact'])->name('shop.contact');
Route::get('/about', [ShopController::class, 'about'])->name('shop.about');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
//Profile
Route::get('/profile', [UserController::class, 'profile'])->name('shop.profile')->middleware('auth');
//Product detail
Route::get('/product/{slug}', [ShopProductController::class, 'show'])->name('shop.product');
//Cart
Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
Route::post('/cart/add/{slug}', [CartController::class, 'add'])->name('shop.cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('shop.cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('shop.cart.remove');
//Order
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('shop.cart.checkout');
Route::get('/payment', [CartController::class, 'payment'])->name('shop.payment');
//Contact
Route::get('/contact', [ContactController::class, 'index'])->name('shop.contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('shop.contact.submit');
//Notification
//API
Route::get('/api/provinces', [LocationController::class, 'getProvinces']);
Route::get('/api/districts', [LocationController::class, 'getDistricts']);
Route::get('/api/wards', [LocationController::class, 'getWards']);
