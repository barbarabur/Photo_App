<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\PhotoController as ApiPhotoController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\API\AuthController;


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
Route::apiResource('user', ApiUserController::class);
Route::apiResource('photo', ApiPhotoController::class);
Route::apiResource('order', ApiOrderController::class);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
    
});
Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [\App\Http\Controllers\API\AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [\App\Http\Controllers\API\AuthController::class, 'me'])->middleware('auth:api');
});

