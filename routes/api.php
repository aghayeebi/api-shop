<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProductController;
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


//Admin
Route::apiResource('brands', BrandController::class);
Route::apiResource('category', CategoryController::class);
Route::get('category/{category}/parent', [CategoryController::class, 'parent']);
Route::get('category/{category}/children', [CategoryController::class, 'children']);


Route::apiResource('category', ProductController::class);
