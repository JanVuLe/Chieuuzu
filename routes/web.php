<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


//ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/login/store', [LoginController::class, 'store'])->name('admin.login.store');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth'])->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        //Dashboard
        Route::get('/dashboard', function(){
            return view('admin.dashboard');
        })->name('admin.dashboard');
        //Users
        Route::resource('/users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create'  => 'admin.users.create',
            'store'   => 'admin.users.store',
            'show'    => 'admin.users.show',
            'edit'    => 'admin.users.edit',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy', 
        ]);
        Route::post('/admin/users/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        //Profile
        Route::get('/profile', function(){
            return view('admin.profile');
        })->name('admin.profile');
    });
});
//SHOP