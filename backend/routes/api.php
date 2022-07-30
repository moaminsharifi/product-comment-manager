<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('signup', [UserController::class, 'signup'])->name('signup');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('user', [UserController::class, 'show'])->name('userData');
    });
});
Route::group([
    'prefix' => 'products',
    'middleware' => 'auth:api',
], function () {
    Route::get('/', [ProductController::class, 'index'])->name('getAllProducts');
});

Route::group([
    'prefix' => 'comments',
    'middleware' => 'auth:api',
], function () {
    Route::post('/', [CommentController::class, 'store'])->name('AddNewComment');
});
