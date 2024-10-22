<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\OperatorAuthController;
use App\Http\Controllers\Api\Auth\PimpinanAuthController;
use App\Http\Controllers\Api\Auth\PimpinanKabanAuthController;
use App\Http\Controllers\Api\Backend\Operator\OperatorController;
use App\Http\Controllers\Api\Backend\Administrator\AdminController;
use App\Http\Controllers\Api\Backend\User\UserController;
use App\Http\Controllers\Api\Auth\VerifikatorDeskAuthController;
use App\Http\Controllers\Api\Auth\VerifikatorFieldAuthController;
use App\Http\Controllers\Api\Backend\Verifikator\VerifikatorDeskController;


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
    Route::post('pimpinanSesban/login', [PimpinanAuthController::class, 'login']);
    Route::post('pimpinanKaban/login', [PimpinanKabanAuthController::class, 'login']);
    Route::post('user', [UserAuthController::class, 'getUserAccount'])->middleware('auth:sanctum');
    Route::get('getListLibrary', [OperatorController::class, 'getListLibrary'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin,type.verifikator_desk,type.verifikator_field']);
    Route::get('getListKomponen', [OperatorController::class, 'getListKomponen'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin,type.verifikator_desk,type.verifikator_field']);
    Route::get('getListBuktiFisik', [OperatorController::class, 'getListBuktiFisik'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin,type.verifikator_desk,type.verifikator_field']);
    Route::post('storeTextEditor', [VerifikatorDeskController::class, 'store'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin,type.verifikator_desk,type.verifikator_field']);
    Route::post('uploadPleno/{id}', [OperatorController::class, 'upload'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin,type.pimpinan,type.pimpinankaban']);
    Route::get('getListPleno', [OperatorController::class, 'getListPleno'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin,type.pimpinan,type.pimpinankaban']);
    Route::get('getPlenoFinal', [OperatorController::class, 'getPlenoFinal'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.verifikator_desk,type.verifikator_field,type.user,type.admin']);
    Route::get('getUser', [OperatorController::class, 'getUserAccount'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    
    //new add route opratro admin
    Route::post('operator/storeGradePleno', [OperatorController::class, 'storeGradePleno'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::post('operator/storeBuktiEvaluasi', [OperatorController::class, 'storeBuktiEvaluasi'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::get('operator/getGrading', [OperatorController::class, 'getGrading'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::post('operator/store/{id}', [OperatorController::class, 'notifyEmailVerifikator'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::put('operator/verified/{id}', [OperatorController::class, 'verified'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::post('operator/notifyEmailVerifikator/{id}', [OperatorController::class, 'notifyEmailVerifikator'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    //end add route operator admin

    //route for eselon
    Route::get('admin/getEselonFungsi', [OperatorController::class, 'getEselonFungsi'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::post('admin/eselonSatu', [OperatorController::class, 'eselonSatu'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::post('admin/eselonDua', [OperatorController::class, 'eselonDua'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::post('admin/eselonTiga', [OperatorController::class, 'eselonTiga'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::post('admin/fungsi', [OperatorController::class, 'fungsi'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);

    Route::get('eselon', [OperatorController::class, 'getEselon']);
    Route::get('eselonDua', [OperatorController::class, 'getEselonDua']);
    Route::get('eselonTiga', [OperatorController::class, 'getEselonTiga']);
    Route::get('fungsi', [OperatorController::class, 'getFungsi']);
    //end route for eselon

    Route::get('operator/getListVerifikatorDesk', [OperatorController::class, 'getListVerifikatorDesk'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);
    Route::get('operator/getListVerifikatorField', [OperatorController::class, 'getListVerifikatorField'])->middleware(['auth:sanctum', 'checkRole:type.operator,type.admin']);

    Route::post('verifikatordesk/login', [VerifikatorDeskAuthController::class, 'login']);
    Route::post('verifikatorfield/login', [VerifikatorFieldAuthController::class, 'login']);

    Route::get('dashboard', [UserController::class, 'dashboardEselon'])->middleware(['auth:sanctum', 'checkRole:type.user,type.admin']);
    
    Route::get('listEvaluasi', [UserController::class, 'listEvaluasi']);
    Route::get('getAllEselon', [UserController::class, 'getAllEselon']);
    Route::get('getAllEselon2', [UserController::class, 'getAllEselon2']);
    Route::get('getAllEselon3', [UserController::class, 'getAllEselon3']);


});

Route::middleware(['auth:sanctum', 'type.user'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::post('user/store', [UserController::class, 'store']);
        Route::get('user/getSubKomponen', [UserController::class, 'getSubKomponen']);
        Route::post('user/storeKomponen', [UserController::class, 'storeKomponen']);
        Route::get('user/getBuktiFisikData', [UserController::class, 'getBuktiFisikData']);
        Route::post('user/storeBuktiFisik', [UserController::class, 'storeBuktiFisik']);
        Route::post('user/storeGoogleForm', [UserController::class, 'storeGoogleForm']);
        
        Route::get('user/getDetailLibrary', [UserController::class, 'getDetailLibrary']);
        Route::get('user/getDetailKomponen', [UserController::class, 'getDetailKomponen']);
        Route::get('user/getDetailBuktiFisik', [UserController::class, 'getDetailBuktiFisik']);
        Route::get('user/getLinkGoogleForm', [UserController::class, 'getLinkGoogleForm']);
        //logout 
        Route::post('user/logout', [UserAuthController::class, 'destory']);
    });
});

Route::middleware(['auth:sanctum', 'type.admin'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('admin/getUser', [AdminController::class, 'getUserAccount']);
        Route::put('admin/verified/{id}', [AdminController::class, 'verified']);
        // Route::get('operator/getListVerifikatorDesk', [OperatorController::class, 'getListVerifikatorDesk']);


         //logout 
         Route::post('admin/logout', [AdminAuthController::class, 'destory']);
    });
});

Route::middleware(['auth:sanctum', 'type.operator'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        // Route::get('operator/getUser', [OperatorController::class, 'getUserAccount']);
        // Route::put('operator/verified/{id}', [OperatorController::class, 'verified']);
        Route::get('operator/generatepdf/{id}', [OperatorController::class, 'generatepdf']);

        // Route::get('operator/getListLibrary', [OperatorController::class, 'getListLibrary']);
        // Route::get('operator/getListKomponen', [OperatorController::class, 'getListKomponen']);
        // Route::get('operator/getListBuktiFisik', [OperatorController::class, 'getListBuktiFisik']);

        Route::get('operator/getDetailData/{id}', [OperatorController::class, 'getDetailData']);

        // Route::get('operator/getListVerifikatorDesk', [OperatorController::class, 'getListVerifikatorDesk']);
        // Route::get('operator/getListVerifikatorField', [OperatorController::class, 'getListVerifikatorField']);

        // Route::post('operator/notifyEmailVerifikator/{id}', [OperatorController::class, 'notifyEmailVerifikator']);
        // Route::post('operator/storeGradePleno', [OperatorController::class, 'storeGradePleno']);
        // Route::post('operator/storeBuktiEvaluasi', [OperatorController::class, 'storeBuktiEvaluasi']);
        // Route::get('operator/getGrading', [OperatorController::class, 'getGrading']);
        // Route::post('operator/store/{id}', [OperatorController::class, 'notifyEmailVerifikator']);
        Route::post('operator/storeLinkGoogleForm', [OperatorController::class, 'storeLinkGoogleForm']);
        Route::get('operator/getLinkGoogleForm', [OperatorController::class, 'getLinkGoogleForm']);
        Route::post('operator/storeKomponenExample', [OperatorController::class, 'storeKomponenExample']);
        Route::get('operator/getKomponen', [OperatorController::class, 'getKomponen']);

        Route::post('operator/eselonSatu', [OperatorController::class, 'eselonSatu']);
        Route::post('operator/eselonDua', [OperatorController::class, 'eselonDua']);
        Route::post('operator/eselonTiga', [OperatorController::class, 'eselonTiga']);
        Route::post('operator/fungsi', [OperatorController::class, 'fungsi']);
        
        Route::get('operator/getEselonFungsi', [AdminController::class, 'getEselonFungsi']);

         //logout 
         Route::post('operator/logout', [OperatorAuthController::class, 'destory']);
    });
    
    
});

Route::middleware(['auth:sanctum', 'type.verifikator_desk'])->group(function () {
        Route::group(['prefix' => 'v1'], function () {
            
            // Route::post('verifikatordesk/store/{id}', [VerifikatorDeskController::class, 'store']);
            Route::post('verifikatordesk/notification/{id}', [VerifikatorDeskController::class, 'notification']);
            

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

Route::middleware(['auth:sanctum', 'type.pimpinan_sesban'])->group(function () {
    
    //logout
    Route::post('pimpinanSesban/logout', [PimpinanAuthController::class, 'login']); 
});