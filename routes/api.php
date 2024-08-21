<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    //User
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        //Categories
        Route::apiResource('categories', CategoryController::class);

        //Products
        Route::apiResource('products', ProductController::class);

        //Logout
        Route::post('/logout', [UserController::class, 'logout']);
    });

});
