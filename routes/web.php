<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\ProductGalleryController;
use App\Http\Controllers\User\StoreController as UserStoreController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

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


Route::group(['middleware' => 'guest'], function()
{
    Route::get('/', [GuestController::class, 'products'])->name('products');
    Route::get('/product/{product:slug}', [GuestController::class, 'productDetails'])->name('products.details');
    Route::get('/store/{store:slug}', [GuestController::class, 'storeDetails'])->name('stores.details');
});

Route::group(['middleware' => ['auth', 'verified']], function()
{
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'is_admin',
        'as' => 'admin.'
    ], function()
    {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user:username}', [UserController::class, 'show'])->name('users.show');
        Route::get('/stores/index', [StoreController::class, 'index'])->name('stores.index');
        Route::get('/stores/{store:slug}', [StoreController::class, 'show'])->name('stores.show');
        Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

        Route::resource('/categories', CategoryController::class)->except('show');
    });

    Route::get('/{user:username}/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/{user:username}/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/{user:username}/information/personals', [ProfileController::class, 'updatePersonal'])->name('personal.update');
    Route::get('/{user:username}/password', [ResetPasswordController::class, 'index'])->name('reset.password');
    Route::put('/{user:username}/password', [ResetPasswordController::class, 'resetPassword'])->name('reset.password.update');
    
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::group([
        'prefix' => 'dashboard',
        'as' => 'dashboard.'
    ], function()
    {
        Route::resource('/stores', UserStoreController::class)->scoped([
            'store' => 'slug'
        ])->except('destroy');
        Route::resource('/products', UserProductController::class)->scoped([
            'product' => 'slug'
        ]);
        Route::resource('/products.galleries', ProductGalleryController::class)->scoped([
            'product' => 'slug'
        ])->only(['create', 'store', 'destroy']);
        Route::resource('/products.carts', CartController::class)
        ->scoped([
            'product' => 'slug'
        ])->only('store');
        Route::resource('/users.carts', CartController::class)
        ->scoped([
            'user' => 'username'
        ])->only(['index', 'destroy'])->shallow();
        Route::get('/transactions/callback', [TransactionController::class, 'callback'])->name('midtrans.callback');
        Route::resource('/users.transactions', TransactionController::class)->scoped([
            'user' => 'username',
            'transaction' => 'unique_number'
        ])->only(['index', 'store', 'show']);
    });
});

require __DIR__.'/auth.php';
