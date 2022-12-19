<?php

use App\Http\Controllers\V1\Admin\ComplianceAuditController;
use App\Http\Controllers\V1\AdminController;
use App\Http\Controllers\V1\GroupController;
use App\Http\Controllers\V1\Admin\PermissionController;
use App\Http\Controllers\V1\Admin\EmailController;
use App\Http\Controllers\V1\Admin\FabricContentController;
use App\Http\Controllers\V1\Admin\FabricQualityController;
use App\Http\Controllers\V1\Admin\InspectionController;
use App\Http\Controllers\V1\Admin\ManualPoController;
use App\Http\Controllers\V1\Admin\ManualPoDeliveryDetailsController;
use App\Http\Controllers\V1\Admin\ManualPoItemDetailsController;
use App\Models\ManualPoDeliveryDetails;
use Illuminate\Http\Request;
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

/**
 * Admin Login Section
 */
Route::prefix("admin")->group(function(){
    Route::get('/login', [AdminController::class, "login"]);
    Route::post('/login', [AdminController::class, "login"]);
    Route::post('/forget-password', [AdminController::class, "forgetPassword"]);
    Route::post('/password-reset', [AdminController::class, "passwordReset"]);
});

/********************************************************************************
 * Protect the Route Throw Admin API Token
 * All Admin Routes are Here
 ********************************************************************************/

Route::middleware(["auth:admin"])->prefix('admin')->group(function(){

    /**
     * Admin Section
     */
    Route::get('/list',[AdminController::class,'index']);
    Route::get('/show', [AdminController::class, 'show']);
    Route::post('/store',[AdminController::class,'store']);
    Route::post('/update', [AdminController::class, 'update']);
    Route::post('/delete', [AdminController::class, 'destroy']);
    Route::post('/logout', [AdminController::class, "logout"]);

    /**
     * Group Section
     */
    Route::prefix("group")->group(function(){
        Route::get('/',[GroupController::class,'index']);
        Route::get('/show', [GroupController::class, 'show']);
        Route::post('/store',[GroupController::class,'store']);
        Route::post('/update',[GroupController::class,'update']);
        Route::post('/delete',[GroupController::class,'destroy']);
    });

    /**
     * Group Permission Section
     */
    Route::prefix('group/permission')->group(function(){
        Route::get('/list', [PermissionController::class, "permissionList"]);
        Route::post('/store', [PermissionController::class, "store"]);
        Route::get('/view', [PermissionController::class, "viewGroupPermission"]);
        Route::get('/user-access', [PermissionController::class, "userAccess"]);
    });

    /**
     * Email Template
     */
    Route::prefix('email-template')->group(function(){
        Route::get('/list', [EmailController::class, 'index']);
        Route::get('/create', [EmailController::class, 'create']);
        Route::post('/create', [EmailController::class, 'store']);
        Route::post('/update', [EmailController::class, 'update']);
        Route::get('view', [EmailController::class, 'view']);
        Route::get('/delete', [EmailController::class, 'delete']);
    });

    /**
     * Compliance Audit
     */
    Route::prefix('compliance-audit')->group(function(){
        
        Route::get('/list', [ComplianceAuditController::class, 'index']);
        Route::post('/store', [ComplianceAuditController::class, 'store']);
        Route::post('/update', [ComplianceAuditController::class, 'update']);
        Route::get('view', [ComplianceAuditController::class, 'show']);
        Route::post('/delete', [ComplianceAuditController::class, 'delete']);
        Route::post('/updateFile', [ComplianceAuditController::class, 'updateComplianceFileInfo']);
        Route::post('/deleteFile', [ComplianceAuditController::class, 'deleteFileCompliance']);
    });


     /**
     * Inspection
     */
    Route::prefix('inspection')->group(function(){

        Route::get('/list', [InspectionController::class, 'index']);
        Route::post('/store', [InspectionController::class, 'store']);
        Route::post('/update', [InspectionController::class, 'update']);
        Route::get('/show', [InspectionController::class, 'show']);
        Route::post('/delete', [InspectionController::class, 'delete']);
        
    });


    /**
     * Manual Po
     */

    Route::prefix('manual_po')->group(function(){

        Route::get('/list', [ManualPoController::class, 'index']);
        Route::post('/store', [ManualPoController::class, 'store']);
        Route::post('/update', [ManualPoController::class, 'update']);
        Route::get('/show', [ManualPoController::class, 'show']);
        Route::post('/delete', [ManualPoController::class, 'delete']);
        
    });


    /**
     * Manual Po Delivery Details
     */

     Route::prefix('manual_po_delivery_details')->group(function(){

        Route::get('/list', [ManualPoDeliveryDetailsController::class, 'index']);
        Route::post('/store', [ManualPoDeliveryDetailsController::class, 'store']);
        Route::post('/update', [ManualPoDeliveryDetailsController::class, 'update']);
        Route::get('/show', [ManualPoDeliveryDetailsController::class, 'show']);
        Route::post('/delete', [ManualPoDeliveryDetailsController::class, 'delete']);
        
    });


    /**
     * Manual Po Delivery Details
     */

     Route::prefix('manual_po_item_details')->group(function(){

        Route::get('/list', [ManualPoItemDetailsController::class, 'index']);
        Route::post('/store', [ManualPoItemDetailsController::class, 'store']);
        Route::post('/update', [ManualPoItemDetailsController::class, 'update']);
        Route::get('/show', [ManualPoItemDetailsController::class, 'show']);
        Route::post('/delete', [ManualPoItemDetailsController::class, 'delete']);
        
    });


     /**
     * Fabric Content
     */

     Route::prefix('fabric-content')->group(function(){

        Route::get('/list', [FabricContentController::class, 'index']);
        Route::post('/store', [FabricContentController::class, 'store']);
        Route::post('/update', [FabricContentController::class, 'update']);
        Route::get('/show', [FabricContentController::class, 'show']);
        Route::post('/delete', [FabricContentController::class, 'delete']);
        
    });


     /**
     * Fabric Quality
     */

     Route::prefix('fabric-quality')->group(function(){

        Route::get('/list', [FabricQualityController::class, 'index']);
        Route::post('/store', [FabricQualityController::class, 'store']);
        Route::post('/update', [FabricQualityController::class, 'update']);
        Route::get('/show', [FabricQualityController::class, 'show']);
        Route::post('/delete', [FabricQualityController::class, 'delete']);
        
    });
    
});
