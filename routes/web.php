<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(HomeController::class)->as('home.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/product', 'product')->name('product');
});


Route::controller(AuthController::class)->as('auth.')->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'doRegister')->name('doRegister');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::controller(DashboardController::class)->as('dashboard.')->group(function () {
        Route::get('/dashboard', 'index')->name('index');
    });

    Route::prefix('dashboard')->group(function () {
        Route::controller(CategoryController::class)->as('category.')->group(function () {
            Route::get('/category', 'index')->name('index');
            Route::get('/category/create', 'create')->name('create');
            Route::post('/category', 'store')->name('store');
            Route::get('/category/{id}/edit', 'edit')->name('edit');
            Route::put('/category/{id}', 'update')->name('update');
            Route::delete('/category/{id}', 'delete')->name('delete');
        });

        Route::controller(ProductController::class)->as('product.')->group(function () {
            Route::get('product', 'index')->name('index');
            Route::get('product/create', 'create')->name('create');
            Route::post('product', 'store')->name('store');
            Route::get('product/{id}/edit', 'edit')->name('edit');
            Route::put('product/{id}', 'update')->name('update');
            Route::delete('product/{id}', 'delete')->name('delete');
        });
    });

});


