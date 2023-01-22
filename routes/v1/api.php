<?php

use App\Http\Controllers\V1\Admin\AeonContactController;
use App\Http\Controllers\V1\Admin\BulkFabricInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ManualPoDeliveryDetails;
use App\Http\Controllers\V1\AdminController;
use App\Http\Controllers\V1\GroupController;
use App\Http\Controllers\V1\Admin\EmailController;
use App\Http\Controllers\V1\Admin\VendorController;
use App\Http\Controllers\V1\Admin\ManualPoController;
use App\Http\Controllers\V1\Admin\InspectionController;
use App\Http\Controllers\V1\Admin\PermissionController;
use App\Http\Controllers\V1\Admin\FabricContentController;
use App\Http\Controllers\V1\Admin\FabricQualityController;
use App\Http\Controllers\V1\Admin\VendorProfileController;
use App\Http\Controllers\V1\Admin\ComplianceAuditController;
use App\Http\Controllers\V1\Admin\CriticalPathController;
use App\Http\Controllers\V1\Admin\CriticalPathDepartmentController;
use App\Http\Controllers\V1\Admin\CriticalPathFabricTypeController;
use App\Http\Controllers\V1\Admin\CustomerContactPeopleController;
use App\Http\Controllers\V1\Admin\CustomerController;
use App\Http\Controllers\V1\Admin\CustomerDepartmentController;
use App\Http\Controllers\V1\Admin\ExFactoryController;
use App\Http\Controllers\V1\Admin\FileProcessingController;
use App\Http\Controllers\V1\Admin\ManualPoItemDetailsController;
use App\Http\Controllers\V1\Admin\FabricWeightController;
use App\Http\Controllers\V1\Admin\GlobalCertificateController;
use App\Http\Controllers\V1\Admin\InspectionInformationController;
use App\Http\Controllers\V1\Admin\LabDipsEmbellishmentInformationController;
use App\Http\Controllers\V1\Admin\VendorContactPeopleController;
use App\Http\Controllers\V1\Admin\ManualPoDeliveryDetailsController;
use App\Http\Controllers\V1\Admin\ManufacturerCertificateController;
use App\Http\Controllers\V1\Admin\ManufacturerContactPeopleController;
use App\Http\Controllers\V1\Admin\SupplierController;
use App\Http\Controllers\V1\Admin\VendorCertificateController;
use App\Http\Controllers\V1\Admin\VendorManufacturerController;
use App\Http\Controllers\V1\Admin\ManufacturerProfileController;
use App\Http\Controllers\V1\Admin\MillController;
use App\Http\Controllers\V1\Admin\PaymentInfoController;
use App\Http\Controllers\V1\Admin\PpMeetingController;
use App\Http\Controllers\V1\Admin\ProductionInformationController;
use App\Http\Controllers\V1\Admin\ProductionSampleShippingApprovalController;
use App\Http\Controllers\V1\Admin\SampleApprovalInformationController;
use App\Http\Controllers\V1\Admin\SeasonController;

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
        Route::post('/delete', [ComplianceAuditController::class, 'destroy']);
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
        Route::get('/search', [ManualPoController::class, 'manualPoWithBuyerVenor']);


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


     /**
     * Fabric Quality
     */

     Route::prefix('fabric-weight')->group(function(){

        Route::get('/list', [FabricWeightController::class, 'index']);
        Route::post('/store', [FabricWeightController::class, 'store']);
        Route::post('/update', [FabricWeightController::class, 'update']);
        Route::get('/show', [FabricWeightController::class, 'show']);
        Route::post('/delete', [FabricWeightController::class, 'delete']);

    });


         /**
     *Aeon Contact Section
    */
    Route::prefix('aeon-contact')->group(function(){

        Route::get('/list', [AeonContactController::class, 'index']);
        Route::get('/show',  [AeonContactController::class, "show"]);
        Route::post('/store', [AeonContactController::class, "store"]);
        Route::post('/update', [AeonContactController::class, "update"]);
        Route::post('/delete', [AeonContactController::class, "delete"]);
    });


        /**
     *Supplier Section
    */
    Route::prefix('supplier')->group(function(){

        Route::get('/list', [SupplierController::class, 'index']);
        Route::get('/show',  [SupplierController::class, "show"]);
        Route::post('/store', [SupplierController::class, "store"]);
        Route::post('/update', [SupplierController::class, "update"]);
        Route::post('/delete', [SupplierController::class, "delete"]);
    });

      /**
     *Critical Path Department
    */
    Route::prefix('critical-path-department')->group(function(){

        Route::get('/list', [CriticalPathDepartmentController::class, 'index']);
        Route::get('/show',  [CriticalPathDepartmentController::class, "show"]);
        Route::post('/store', [CriticalPathDepartmentController::class, "store"]);
        Route::post('/update', [CriticalPathDepartmentController::class, "update"]);
        Route::post('/delete', [CriticalPathDepartmentController::class, "delete"]);
    });

     /**
     *Critical Path Fabric Type
    */
    Route::prefix('critical-path-fabric-type')->group(function(){

        Route::get('/list', [CriticalPathFabricTypeController::class, 'index']);
        Route::get('/show',  [CriticalPathFabricTypeController::class, "show"]);
        Route::post('/store', [CriticalPathFabricTypeController::class, "store"]);
        Route::post('/update', [CriticalPathFabricTypeController::class, "update"]);
        Route::post('/delete', [CriticalPathFabricTypeController::class, "delete"]);
    });

    /**
     *Season
    */
    Route::prefix('season')->group(function(){

        Route::get('/list', [SeasonController::class, 'index']);
        Route::get('/show',  [SeasonController::class, "show"]);
        Route::post('/store', [SeasonController::class, "store"]);
        Route::post('/update', [SeasonController::class, "update"]);
        Route::post('/delete', [SeasonController::class, "delete"]);
    });

    /**
     *Mill
    */
    Route::prefix('mill')->group(function(){

        Route::get('/list', [MillController::class, 'index']);
        Route::get('/show',  [MillController::class, "show"]);
        Route::post('/store', [MillController::class, "store"]);
        Route::post('/update', [MillController::class, "update"]);
        Route::post('/delete', [MillController::class, "delete"]);
    });


     /**
     *LabDips Embellishment Information
    */
    Route::prefix('labdips-embellishment-Information')->group(function(){

        Route::get('/list', [LabDipsEmbellishmentInformationController::class, 'index']);
        Route::get('/show',  [LabDipsEmbellishmentInformationController::class, "show"]);
        Route::post('/store', [LabDipsEmbellishmentInformationController::class, "store"]);
        Route::post('/update', [LabDipsEmbellishmentInformationController::class, "update"]);
        Route::post('/delete', [LabDipsEmbellishmentInformationController::class, "delete"]);
    });


     /**
     *Bulk Fabric Information
    */
    Route::prefix('bulk-fabric-Information')->group(function(){

        Route::get('/list', [BulkFabricInformationController::class, 'index']);
        Route::get('/show',  [BulkFabricInformationController::class, "show"]);
        Route::post('/store', [BulkFabricInformationController::class, "store"]);
        Route::post('/update', [BulkFabricInformationController::class, "update"]);
        Route::post('/delete', [BulkFabricInformationController::class, "delete"]);
    });


    /**
     *Sample Approval Information
    */
    Route::prefix('sample-approval-Information')->group(function(){

        Route::get('/list', [SampleApprovalInformationController::class, 'index']);
        Route::get('/show',  [SampleApprovalInformationController::class, "show"]);
        Route::post('/store', [SampleApprovalInformationController::class, "store"]);
        Route::post('/update', [SampleApprovalInformationController::class, "update"]);
        Route::post('/delete', [SampleApprovalInformationController::class, "delete"]);
    });

    /**
     *PP Meeting Details Information
    */
    Route::prefix('pp-meeting-details')->group(function(){

        Route::get('/list', [PpMeetingController::class, 'index']);
        Route::get('/show',  [PpMeetingController::class, "show"]);
        Route::post('/store', [PpMeetingController::class, "store"]);
        Route::post('/update', [PpMeetingController::class, "update"]);
        Route::post('/delete', [PpMeetingController::class, "delete"]);
    });

    /**
     *Production Information Details Information
    */
    Route::prefix('production-information-details')->group(function(){

        Route::get('/list', [ProductionInformationController::class, 'index']);
        Route::get('/show',  [ProductionInformationController::class, "show"]);
        Route::post('/store', [ProductionInformationController::class, "store"]);
        Route::post('/update', [ProductionInformationController::class, "update"]);
        Route::post('/delete', [ProductionInformationController::class, "delete"]);
    });

    /**
     *Inspection Information Details Information
    */
    Route::prefix('inspection-information')->group(function(){

        Route::get('/list', [InspectionInformationController::class, 'index']);
        Route::get('/show',  [InspectionInformationController::class, "show"]);
        Route::post('/store', [InspectionInformationController::class, "store"]);
        Route::post('/update', [InspectionInformationController::class, "update"]);
        Route::post('/delete', [InspectionInformationController::class, "delete"]);
    });

    /**
     *Inspection Information Details Information
    */
    Route::prefix('shipping-approval-information')->group(function(){

        Route::get('/list', [ProductionSampleShippingApprovalController::class, 'index']);
        Route::get('/show',  [ProductionSampleShippingApprovalController::class, "show"]);
        Route::post('/store', [ProductionSampleShippingApprovalController::class, "store"]);
        Route::post('/update', [ProductionSampleShippingApprovalController::class, "update"]);
        Route::post('/delete', [ProductionSampleShippingApprovalController::class, "delete"]);
    });

    /**
     *Critical Path
    */
    Route::prefix('critical-path')->group(function(){

        Route::get('/list', [CriticalPathController::class, 'index']);
        Route::get('/show',  [CriticalPathController::class, "show"]);
        Route::post('/store', [CriticalPathController::class, "store"]);
        Route::post('/update', [CriticalPathController::class, "update"]);
        Route::post('/delete', [CriticalPathController::class, "delete"]);
    });



    /**
     * Vendor
     */
    Route::prefix('vendor')->group(function(){

        Route::get('/list', [VendorController::class, 'index']);
        Route::post('/store', [VendorController::class, 'store']);
        Route::post('/update/{id}', [VendorController::class, 'update']);
        Route::get('/show', [VendorController::class, 'show']);
        Route::post('/delete/{id}', [VendorController::class, 'delete']);

    });

    /**
    * Vendor Contact People Section
    **/
    Route::prefix('vendor_contact')->group(function(){

        Route::get('/list',         [VendorContactPeopleController::class, 'index']);
        Route::get('/show',         [VendorContactPeopleController::class, "show"]);
        Route::post('/store',       [VendorContactPeopleController::class, "store"]);
        Route::post('/update/{id}', [VendorContactPeopleController::class, "update"]);
        Route::post('/delete/{id}', [VendorContactPeopleController::class, "destroy"]);
    });

     /**
     * Vendor Profile Section
     **/
    Route::prefix('vendor_profile')->group(function(){

        Route::get('/list',         [VendorProfileController::class, 'index']);
        Route::get('/show',         [VendorProfileController::class, "show"]);
        Route::post('/store',       [VendorProfileController::class, "store"]);
        Route::post('/update',      [VendorProfileController::class, "update"]);
        Route::post('/delete',      [VendorProfileController::class, "delete"]);
        Route::post('/updateFile',  [VendorProfileController::class, 'updateAttachFile']);
        Route::post('/deleteFile',  [VendorProfileController::class, 'deleteAttachFile']);
    });

    /**
     * Customer Section
     */
    Route::prefix('customer')->group(function(){

        Route::get('/list',         [CustomerController::class, 'index']);
        Route::get('/show',         [CustomerController::class, "show"]);
        Route::post('/store',       [CustomerController::class, "store"]);
        Route::post('/update/{id}', [CustomerController::class, "update"]);
        Route::post('/delete/{id}', [CustomerController::class, "destroy"]);
    });

    /**
     * Customer Contact People Section
     */
    Route::prefix('customer_contact')->group(function(){

        Route::get('/list',         [CustomerContactPeopleController::class, 'index']);
        Route::get('/show',         [CustomerContactPeopleController::class, "show"]);
        Route::post('/store',       [CustomerContactPeopleController::class, "store"]);
        Route::post('/update/{id}', [CustomerContactPeopleController::class, "update"]);
        Route::post('/delete/{id}', [CustomerContactPeopleController::class, "destroy"]);
    });


    /**
     * Customer Department Section
     */
     Route::prefix('customer_department')->group(function(){

        Route::get('/list',         [CustomerDepartmentController::class, 'index']);
        Route::get('/show',         [CustomerDepartmentController::class, "show"]);
        Route::post('/store',       [CustomerDepartmentController::class, "store"]);
        Route::post('/update',      [CustomerDepartmentController::class, "update"]);
        Route::post('/delete',      [CustomerDepartmentController::class, "delete"]);
    });

    /**
     *Vendor Certificate Section
     */
    Route::prefix('vendor_certificate')->group(function(){

        Route::get('/list',         [VendorCertificateController::class, 'index']);
        Route::get('/show',         [VendorCertificateController::class, "show"]);
        Route::post('/store',       [VendorCertificateController::class, "store"]);
        Route::post('/update',      [VendorCertificateController::class, "update"]);
        Route::post('/delete',      [VendorCertificateController::class, "delete"]);
    });

    /**
    * PDF File Process
     */
    Route::prefix('pdf')->group(function(){
        Route::post('process', [FileProcessingController::class, "process"]);
    });

    /**
     *Global Certificate Section
    */
    Route::prefix('global_certificate')->group(function(){

        Route::get('/list',         [GlobalCertificateController::class, 'index']);
        Route::get('/show',         [GlobalCertificateController::class, "show"]);
        Route::post('/store',       [GlobalCertificateController::class, "store"]);
        Route::post('/update',      [GlobalCertificateController::class, "update"]);
        Route::post('/delete',      [GlobalCertificateController::class, "delete"]);
    });

    /**
     *Manufacturer Profile Section
    */
    Route::prefix('manufacturer_profile')->group(function(){

        Route::get('/list',         [ManufacturerProfileController::class, 'index']);
        Route::get('/show',         [ManufacturerProfileController::class, "show"]);
        Route::post('/store',       [ManufacturerProfileController::class, "store"]);
        Route::post('/update',      [ManufacturerProfileController::class, "update"]);
        Route::post('/delete',      [ManufacturerProfileController::class, "delete"]);
        Route::post('/updateFile',  [ManufacturerProfileController::class, 'updateAttachFile']);
        Route::post('/deleteFile',  [ManufacturerProfileController::class, 'deleteAttachFile']);
    });


    /**
     *Vendor Manufacturer Section
    */
    Route::prefix('vendor_manufacturer')->group(function(){

        Route::get('/list',         [VendorManufacturerController::class, 'index']);
        Route::get('/show',         [VendorManufacturerController::class, "show"]);
        Route::post('/store',       [VendorManufacturerController::class, "store"]);
        Route::post('/update/{id}', [VendorManufacturerController::class, "update"]);
        Route::post('/delete/{id}', [VendorManufacturerController::class, "destroy"]);
    });
     /**
     * Manufacturar Certificate Section
     **/
    Route::prefix('manufacturer_certificate')->group(function(){

        Route::get('/list',         [ManufacturerCertificateController::class, 'index']);
        Route::get('/show',         [ManufacturerCertificateController::class, "show"]);
        Route::post('/store',       [ManufacturerCertificateController::class, "store"]);
        Route::post('/update',      [ManufacturerCertificateController::class, "update"]);
        Route::post('/delete',      [ManufacturerCertificateController::class, "delete"]);
    });

     /**
     * Manufacturar Contact People Section
     **/
    Route::prefix('manufacturer_contact')->group(function(){

        Route::get('/list',         [ManufacturerContactPeopleController::class, 'index']);
        Route::get('/show',         [ManufacturerContactPeopleController::class, "show"]);
        Route::post('/store',       [ManufacturerContactPeopleController::class, "store"]);
        Route::post('/update',      [ManufacturerContactPeopleController::class, "update"]);
        Route::post('/delete',      [ManufacturerContactPeopleController::class, "delete"]);
    });

     /**
     * Manufacturar Contact People Section
     **/
    Route::prefix('payment')->group(function(){

        Route::get('/list',         [PaymentInfoController::class, 'index']);
        Route::get('/show',         [PaymentInfoController::class, "show"]);
        Route::post('/store',       [PaymentInfoController::class, "store"]);
        Route::post('/update',      [PaymentInfoController::class, "update"]);
        Route::post('/delete',      [PaymentInfoController::class, "delete"]);
    });

     /**
     * Manufacturar Contact People Section
     **/
    Route::prefix('ex-factory')->group(function(){

        Route::get('/list',         [ExFactoryController::class, 'index']);
        Route::get('/show',         [ExFactoryController::class, "show"]);
        Route::post('/store',       [ExFactoryController::class, "store"]);
        Route::post('/update',      [ExFactoryController::class, "update"]);
        Route::post('/delete',      [ExFactoryController::class, "delete"]);
    });



});
