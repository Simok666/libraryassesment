<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\OperatorAuthController;
use App\Http\Controllers\Api\Auth\PimpinanAuthController;
use App\Http\Controllers\Api\Backend\Operator\OperatorController;
use App\Http\Controllers\Api\Backend\Administrator\AdminController;
use App\Http\Controllers\Api\Backend\User\UserController;
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

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('user/login', [UserAuthController::class, 'login']);
    Route::post('user/register', [UserAuthController::class, 'register']);
    Route::post('admin/login', [AdminAuthController::class, 'login']);
    Route::post('operator/login', [OperatorAuthController::class, 'login']);
    Route::post('pimpinan/login', [PimpinanAuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'type.user'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::post('user/store', [UserController::class, 'store']);
    });
});

Route::middleware(['auth:sanctum', 'type.admin'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('admin/getUser', [AdminController::class, 'getUserAccount']);
        Route::put('admin/verified/{id}', [AdminController::class, 'verified']);
    });
});

Route::middleware(['auth:sanctum', 'type.operator'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('operator/getUser', [OperatorController::class, 'getUserAccount']);
        Route::put('operator/verified/{id}', [OperatorController::class, 'verified']);
    });
    
    
});

Route::middleware(['auth:sanctum', 'type.pimpinan'])->group(function () {
    
});