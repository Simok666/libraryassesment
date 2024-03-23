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
use App\Http\Controllers\Api\Auth\VerifikatorDeskAuthController;
use App\Http\Controllers\Api\Auth\VerifikatorFieldAuthController;

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
    Route::post('user', [UserAuthController::class, 'getUserAccount'])->middleware('auth:sanctum');
    Route::post('verifikatordesk/login', [VerifikatorDeskAuthController::class, 'login']);
    Route::post('verifikatorfield/login', [VerifikatorFieldAuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'type.user'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::post('user/store', [UserController::class, 'store']);
        Route::get('user/getSubKomponen', [UserController::class, 'getSubKomponen']);
        Route::post('user/storeKomponen', [UserController::class, 'storeKomponen']);
        Route::get('user/getBuktiFisikData', [UserController::class, 'getBuktiFisikData']);
        Route::post('user/storeBuktiFisik', [UserController::class, 'storeBuktiFisik']);

        //logout 
        Route::post('user/logout', [UserAuthController::class, 'destory']);
    });
});

Route::middleware(['auth:sanctum', 'type.admin'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('admin/getUser', [AdminController::class, 'getUserAccount']);
        Route::put('admin/verified/{id}', [AdminController::class, 'verified']);

         //logout 
         Route::post('admin/logout', [AdminAuthController::class, 'destory']);
    });
});

Route::middleware(['auth:sanctum', 'type.operator'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('operator/getUser', [OperatorController::class, 'getUserAccount']);
        Route::put('operator/verified/{id}', [OperatorController::class, 'verified']);

        Route::get('operator/getListLibrary', [OperatorController::class, 'getListLibrary']);
        Route::get('operator/getListKomponen', [OperatorController::class, 'getListKomponen']);
        Route::get('operator/getListBuktiFisik', [OperatorController::class, 'getListBuktiFisik']);

        Route::get('operator/getDetailLibrary/{id}', [OperatorController::class, 'getDetailLibrary']);
        Route::get('operator/getDetailKomponen/{id}', [OperatorController::class, 'getDetailKomponen']);
        Route::get('operator/getDetailBuktiFisik/{id}', [OperatorController::class, 'getDetailBuktiFisik']);

        Route::get('operator/getListVerifikatorDesk', [OperatorController::class, 'getListVerifikatorDesk']);
        Route::get('operator/getListVerifikatorField', [OperatorController::class, 'getListVerifikatorField']);

        Route::post('operator/notifyEmailDesk/{id}', [OperatorController::class, 'notifyEmailDesk']);
        Route::post('operator/notifyEmailField/{id}', [OperatorController::class, 'notifyEmailField']);
        
         //logout 
         Route::post('operator/logout', [OperatorAuthController::class, 'destory']);
    });
    
    
});

Route::middleware(['auth:sanctum', 'type.verifikator_desk'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
    
        //logout
        Route::post('verifikatordesk/logout', [VerifikatorDeskAuthController::class, 'destory']);
    });
});

Route::middleware(['auth:sanctum', 'type.verifikator_field'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
   
        //logout
        Route::post('verifikatorfield/logout', [VerifikatorFieldAuthController::class, 'destory']);
    });
});

Route::middleware(['auth:sanctum', 'type.pimpinan'])->group(function () {
    
});