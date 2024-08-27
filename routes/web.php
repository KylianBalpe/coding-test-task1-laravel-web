<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(AuthController::class)->as('auth.')->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'doRegister')->name('doRegister');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/dashboard', function () {
    return view('dashboard.index', ['title' => 'Dashboard']);
})->name('dashboard');

Route::controller(CategoryController::class)->as('category.')->group(function () {
    Route::get('/category', 'index')->name('index');
    Route::get('/category/create', 'create')->name('create');
    Route::post('/category', 'store')->name('store');
    Route::get('/category/{id}/edit', 'edit')->name('edit');
    Route::put('/category/{id}', 'update')->name('update');
    Route::delete('/category/{id}', 'delete')->name('delete');
});
