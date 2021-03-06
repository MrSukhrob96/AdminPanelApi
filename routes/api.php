<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;

Route::post('login', [AuthController::class, 'login']);

Route::apiResource('orders', OrderController::class)->only('index', 'show');

Route::middleware(['auth:api'])->group(function () {
	Route::get('user', [UserController::class, 'user']);
	Route::put('users/info', [UserController::class, 'updateInfo']);
	Route::put('users/password', [UserController::class, 'updatePassword']);
	Route::post('upload', [ImageController::class, 'upload']);
	Route::get('export/csv', [OrderController::class, 'export']);

	Route::apiResource('users', UserController::class);
	Route::apiResource('roles', RolesController::class);
	Route::apiResource('products', ProductsController::class);
	Route::apiResource('orders', OrderController::class)->only('index', 'show');
	Route::apiResource('permissions', PermissionController::class)->only('index', 'show');
});
