<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer', 'index');
    Route::get('/customer/{id}', 'show');
    Route::post('/customer', 'store');
    Route::post('/login', 'login');
    Route::post('/customer/{id}', 'update');
    Route::delete('/customer/{id}', 'destroy');

    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/verify-otp', 'verifyOtp');
    Route::post('/reset-password', 'resetPassword');

    Route::get('/checkAuth', 'checkAuth')->middleware('auth:api');
    Route::get( '/unauthenticated', 'unauthenticated')->name('login');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index');
    Route::get('/product/home', 'home');
    Route::get('/product/category', 'categoryList');
    Route::get('/product/{id}', 'show');
});

Route::controller(WishlistController::class)->group(function () {
    Route::get('/wishlist', 'index');
    Route::get('/wishlist/{id}', 'show');
    Route::post('/wishlist', 'store')->middleware('auth:api');
    Route::delete('/wishlist/{id}', 'destroy')->middleware('auth:api');
});

Route::get('/test', function () {
    return 'test';
});
