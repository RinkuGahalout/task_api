<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::post('/login',[LoginController::class,'login']);
route::post('/registation',[LoginController::class,'registation']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Product CRUD routes
    route::get('/products',[ProductController::class,'index']);
    route::post('/products',[ProductController::class,'store']);
    route::put('/update/{id}',[ProductController::class,'update']);
    route::delete('/delete/{id}',[ProductController::class,'destroy']);
    route::get('/search/{name}',[ProductController::class,'search']);

    // Blog module routes
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::get('/blogs/{id}', [BlogController::class, 'show']);
    Route::put('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

    // Fetch Posts with Comments
    Route::get('/posts', [PostController::class, 'index']);

    Route::post('upload', [ImageController::class, 'store']);
    Route::get('images', [ImageController::class, 'index']);

    Route::post('/logout', [LoginController::class, 'logout']);
});