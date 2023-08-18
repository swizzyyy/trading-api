<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::post('/login', 'AuthController@login');
Route::post('/auth/token',[AuthController::class,'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('product', ProductsResource::class);
    Route::post('/product/availability', [ProductController::class,'checkAvailability']);
    Route::post('/product/suitability', [ProductController::class,'checkSuitability']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
