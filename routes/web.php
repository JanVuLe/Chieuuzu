<?php
//ADMIN
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
//SHOP
use App\Http\Controllers\Auth\ShopLoginController;
use App\Http\Controllers\Auth\ShopRegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\ContactController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\LocationController;
use App\Http\Controllers\Shop\NotificationController;
use App\Http\Controllers\Shop\ProfileController as ShopProfileController;
use App\Http\Controllers\Shop\NewsController;
use App\Http\Controllers\Shop\ReviewController;
use Illuminate\Support\Facades\Route;


//ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('/login/store', [AdminLoginController::class, 'store'])->name('admin.login.store');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth.admin', 'role:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
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
        Route::delete('/warehouses/{warehouseId}/remove-product/{productId}', [WarehouseController::class, 'removeProduct'])->name('admin.warehouses.removeProduct');
        Route::post('/warehouses/{id}/add-product', [WarehouseController::class, 'addProduct'])->name('admin.warehouses.addProduct');
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
        Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::get('/order-success/{orderId}', [CartController::class, 'orderSuccess'])->name('shop.order.success');
        //Revenue
        Route::get('/revenue', [RevenueController::class, 'index'])->name('admin.revenue.index');
        //News
        Route::resource('/news', AdminNewsController::class)->parameters(['news' => 'slug'])->names([
            'index'   => 'admin.news.index',
            'create'  => 'admin.news.create',
            'store'   => 'admin.news.store',
            'show'    => 'admin.news.show',
            'edit'    => 'admin.news.edit',
            'update'  => 'admin.news.update',
            'destroy' => 'admin.news.destroy'
        ]);
        //Profile
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
    });
});

//SHOP
Route::get('/', [ShopController::class, 'index'])->name('shop.home');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/about', [ShopController::class, 'about'])->name('shop.about');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');

// Authentication (Login, Register, Logout)
Route::get('/login', [ShopLoginController::class, 'showLoginForm'])->name('shop.login');
Route::post('/login/store', [ShopLoginController::class, 'store'])->name('shop.login.store');
Route::post('/logout', [ShopLoginController::class, 'logout'])->name('shop.logout');
Route::get('/register', [ShopRegisterController::class, 'showRegisterForm'])->name('shop.register');
Route::post('/register', [ShopRegisterController::class, 'register'])->name('shop.register.store');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Product
Route::get('/product/{slug}', [ShopProductController::class, 'show'])->name('shop.product');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('shop.contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('shop.contact.submit');
Route::post('/contact-support', [ContactController::class, 'contactSupport'])->name('shop.contact.support');

// API (Location)
Route::get('/api/provinces', [LocationController::class, 'getProvinces'])->name('api.provinces');
Route::get('/api/districts', [LocationController::class, 'getDistricts'])->name('api.districts');
Route::get('/api/wards', [LocationController::class, 'getWards'])->name('api.wards');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
Route::post('/cart/add/{slug}', [CartController::class, 'add'])->name('shop.cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('shop.cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('shop.cart.remove');

// Google Login
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');


// News
Route::get('/news', [NewsController::class, 'index'])->name('shop.news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('shop.news.show');

// Routes yêu cầu đăng nhập
Route::middleware(['auth', 'role:user'])->group(function () {
    // Profile
    Route::get('/profile', [ShopProfileController::class, 'index'])->name('shop.profile');
    Route::post('/profile/update', [ShopProfileController::class, 'update'])->name('shop.profile.update');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('shop.notifications');
    // Cart
    Route::get('/payment', [CartController::class, 'payment'])->name('shop.payment');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('shop.cart.checkout');
    // Order
    Route::get('/order-success/{orderId}', [CartController::class, 'orderSuccess'])->name('shop.order.success');
    Route::post('/order/cancel/{orderId}', [CartController::class, 'cancelOrder'])->name('shop.order.cancel');
    Route::get('/order/{orderId}', [CartController::class, 'show'])->name('shop.order.show');
    // Notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('shop.notifications');
    Route::get('/shop/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('shop.notification.markAsRead');
    // Review
    Route::post('/review', [ReviewController::class, 'store'])->name('shop.review.store');
});

// Test
Route::get('/test', function () {
    return view('test.static');
})->name('test');
