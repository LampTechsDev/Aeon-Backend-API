<?php

use App\Http\Controllers\V1\Admin\EmailController;
use App\Http\Controllers\V1\Admin\PermissionController;
use App\Http\Controllers\V1\Admin\TherapistController;
use App\Http\Controllers\V1\AdminController;
use App\Http\Controllers\V1\AppointmentController;
use App\Http\Controllers\V1\Admin\TherapistDegreeController;
use App\Http\Controllers\V1\Admin\TherapistServiceController;
use App\Http\Controllers\V1\BloodGroupController;
use App\Http\Controllers\V1\CountryController;
use App\Http\Controllers\V1\OccupationController;
use App\Http\Controllers\V1\PatientController;
use App\Http\Controllers\V1\ServiceCategoryController;
use App\Http\Controllers\V1\ServiceSubCategoryController;
use App\Http\Controllers\V1\StateController;
use App\Http\Controllers\V1\TherapistTypeController;
use App\Http\Controllers\V1\TicketDepartmentController;
use App\Http\Controllers\V1\Admin\TicketController;
use App\Http\Controllers\V1\DegreeController;
use App\Http\Controllers\V1\QuestionController;
use App\Http\Controllers\V1\GroupController;
use App\Http\Controllers\V1\Admin\TherapistScheduleController;
use App\Http\Controllers\V1\Patient\TicketController as PatientTicketController;
use App\Http\Controllers\V1\PibFormulaController;
use App\Http\Controllers\V1\PitFormulaController;
use App\Http\Controllers\V1\PibScaleController;
use App\Http\Controllers\V1\PitScaleController;
use App\Http\Controllers\V1\Therapist\AppointmentController as TherapistAppointmentController;
use App\Http\Controllers\V1\Therapist\TicketController as TherapistTicketController;
use App\Http\Controllers\V1\TicketHistoryActivityController;
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
    Route::get('/login', [AdminController::class, "showLogin"]);
    Route::post('/login', [AdminController::class, "login"]);
    Route::get('/adminview', [AdminController::class, "index"]);
    Route::get('/show', [AdminController::class, 'show']);
    Route::post('/store', [AdminController::class, "store"]);
    Route::post('forget-password', [AdminController::class, "forgetPassword"]);
    Route::post('password-reset', [AdminController::class, "passwordReset"]);
});

/**
 * Protect the Route Throw API Token
 */
Route::middleware(["auth:admin"])->group(function(){
    Route::post('admin/logout', [AdminController::class, "logout"]);
    Route::post('/admin/update/{id}', [AdminController::class, 'update']);
    Route::post('/admin/delete/{id}', [AdminController::class, 'destroy']);
    /**
     * Ticket
     */
    Route::prefix('admin/ticket')->group(function(){
        Route::get('/', [TicketController::class, 'index']);
        Route::post('/create', [TicketController::class, 'store']);
        Route::get('/show', [TicketController::class, 'show']);
        Route::get('/tickethistory', [TicketController::class, 'ticketHistoryActivity']);
        Route::get('/tickethistoryshow', [TicketController::class, 'ticketHistoryActivityshow']);
        Route::post('/update', [TicketController::class, 'update']);
        Route::post('/delete', [TicketController::class, 'deleteTicket']);
        Route::post('/cancelticket', [TicketController::class, 'cancelticket']);
        Route::post('/assignedticket', [TicketController::class, 'assignedticket']);
        //Route::get('/tickethistoryshow', [TicketController::class, 'ticketHistoryActivityshow']);
        Route::post('/ticketuploaddelete', [TicketController::class, 'deleteFileTicket']);
        Route::post('/ticketAddfile', [TicketController::class, 'addFileTicket']);

        // Reply On Ticket
        Route::prefix("reply")->group(function(){
            Route::get('/', [TicketController::class, 'replyList']);
            Route::post('/create', [TicketController::class, 'addReply']);
            Route::get('/edit', [TicketController::class, 'editReply']);
            Route::post('/update', [TicketController::class, 'updateReply']);
            Route::get('/delete', [TicketController::class, 'deleteReply']);
        });
    });

        
    //Pit Formula Section
    Route::prefix('pit')->group(function(){
        Route::get('/', [PitFormulaController::class, 'index']);
        Route::get('/show', [PitFormulaController::class, 'show']);
        Route::post('/store', [PitFormulaController::class, 'store']);
        Route::post('/update/{id}', [PitFormulaController::class, 'update']);
        Route::post('/delete/{id}', [PitFormulaController::class, 'destroy']);
    });

    //Pit Scale Section
    Route::prefix('pitscale')->group(function(){
        Route::get('/', [PitScaleController::class, 'index']);
        Route::get('/show', [PitScaleController::class, 'show']);
        Route::post('/store', [PitScaleController::class, 'store']);
        Route::post('/update/{id}', [PitScaleController::class, 'update']);
        Route::post('/delete/{id}', [PitScaleController::class, 'destroy']);
    });

    //PiB Formula Section
    Route::prefix('pib')->group(function(){
        Route::get('/', [PibFormulaController::class, 'index']);
        Route::post('/store', [PibFormulaController::class, 'store']);
        Route::get('/show', [PibFormulaController::class, 'show']);
        Route::post('/update', [PibFormulaController::class, 'update']);
        Route::post('/delete', [PibFormulaController::class, 'destroy']);
    });

    //PiB Scale Section
    Route::prefix('pibscale')->group(function(){
        Route::get('/', [PibScaleController::class, 'index']);
        Route::post('/store', [PibScaleController::class, 'store']);
        Route::get('/show', [PibScaleController::class, 'show']);
        Route::post('/update', [PibScaleController::class, 'update']);
        Route::any('/delete', [PibScaleController::class, 'destroy']);
    });

    //Patient Create
    Route::prefix('patientinfo')->group(function(){
        Route::get('', [PatientController::class, 'index']);
        Route::get('/missingInfoPatient', [PatientController::class, 'missingInfoPatient']);
        Route::get('/show', [PatientController::class, 'show']);
        Route::get('/missingInfoPatient', [PatientController::class, 'missingInfoPatient']);
        Route::post('/store', [PatientController::class, 'store']);
        Route::post('/update/{id}', [PatientController::class, 'update']);
        Route::post('/patientuploaddelete', [PatientController::class, 'deleteFilePatient']);
        Route::post('/patientAddfile', [PatientController::class, 'addFilePatient']);
        Route::post('/delete/{id}', [PatientController::class, 'destroy']);
    });

    //Group Create

    Route::get('/groups',[GroupController::class,'index']);
    Route::get('/groups/show', [GroupController::class, 'show']);
    Route::post('/groups/store',[GroupController::class,'store']);
    Route::post('/groups/update/{id}',[GroupController::class,'update']);
    Route::post('/groups/delete/{id}',[GroupController::class,'destroy']);

    /**
     * Group Permission
     */
    Route::prefix('group/permission')->group(function(){
        Route::get('/list', [PermissionController::class, "permissionList"]);
        Route::post('/store', [PermissionController::class, "store"]);
        Route::get('/view', [PermissionController::class, "viewGroupPermission"]);
        Route::get('/user-access', [PermissionController::class, "userAccess"]);
    });

    //Ticket Department
    Route::prefix('ticket_department')->group(function(){
        Route::get('/', [TicketDepartmentController::class, 'index']);
        Route::get('/show', [TicketDepartmentController::class, 'show']);
        Route::post('/store', [TicketDepartmentController::class, 'store']);
        Route::post('/update', [TicketDepartmentController::class, 'update']);
        Route::post('/delete/{id}', [TicketDepartmentController::class, 'destroy']);
    });

    //Therapist Section

    //Therapist Type
    Route::get('/therapist_type', [TherapistTypeController::class, 'index']);
    Route::post('/therapist_type/store', [TherapistTypeController::class, 'store']);
    Route::post('/therapist_type/update/{id}', [TherapistTypeController::class, 'update']);
    Route::post('/therapist_type/delete/{id}', [TherapistTypeController::class, 'destroy']);

    Route::prefix('therapistinfo')->group(function(){
        Route::get('/', [TherapistController::class, 'index']);
        Route::get('/show', [TherapistController::class, 'show']);
        Route::post('/store', [TherapistController::class, 'store']);
        Route::post('/update', [TherapistController::class, 'update']);
        Route::post('/therapistuploaddelete', [TherapistController::class, 'deleteFileTherapist']);
        Route::post('/therapistAddfile', [TherapistController::class, 'addFileTherapist']);
        Route::post('/delete/{id}', [TherapistController::class, 'destroy']);
    });

    //Therapist Service
    Route::prefix('therapistService')->group(function(){
        Route::get('/', [TherapistServiceController::class, 'index']);
        Route::get('/show', [TherapistServiceController::class, 'show']);
        Route::post('/store', [TherapistServiceController::class, 'store']);
        Route::post('/update/{id}', [TherapistServiceController::class, 'update']);
        Route::post('/delete/{id}', [TherapistServiceController::class, 'destroy']);
    });

    //Therapist Degree
    Route::prefix('therapist_degree')->group(function(){
        Route::get('/', [TherapistDegreeController::class, 'index']);
        Route::get('/show', [TherapistDegreeController::class, 'show']);
        Route::post('/store', [TherapistDegreeController::class, 'store']);
        Route::post('/update/{id}', [TherapistDegreeController::class, 'update']);
        Route::post('/delete/{id}', [TherapistDegreeController::class, 'destroy']);
    });


    //Therapist Schedule
    Route::prefix('therapist-schedule')->group(function () {
        Route::get('/list', [TherapistScheduleController::class, 'index']);
        Route::get('/create', [TherapistScheduleController::class, 'create']);
        Route::post('/create', [TherapistScheduleController::class, 'store']);
        Route::get('/show', [TherapistScheduleController::class, 'show']);
        Route::post('delete', [TherapistScheduleController::class, 'destroy']);
    });

    //Appointment
    Route::prefix('appointment')->group(function(){
        Route::get('/', [AppointmentController::class, 'index']);
        Route::get('/show', [AppointmentController::class, 'show']);
        Route::post('/store', [AppointmentController::class, 'store']);
        Route::post('/update', [AppointmentController::class, 'update']);
        Route::post('/appointmentticketstatus', [AppointmentController::class, 'assignedappointmentticketstatus']);
        Route::post('/appointmentuploaddelete', [AppointmentController::class, 'deleteFileAppointment']);
        Route::post('/appointmentAddfile', [AppointmentController::class, 'addFileAppointment']);
        Route::post('/delete/{id}', [AppointmentController::class, 'destroy']);
    });

    //Question
    //Question
    Route::get('/question', [QuestionController::class, 'index']);
    Route::post('/question/store', [QuestionController::class, 'store']);
    Route::get('/question/show', [QuestionController::class, 'show']);
    Route::post('/question/update/{id}', [QuestionController::class, 'update']);
    Route::post('/question/delete/{id}', [QuestionController::class, 'destroy']);
    

    //Pib Formula
    Route::get('/formula', [PibFormulaController::class, 'index']);
    Route::post('/formula/store', [PibFormulaController::class, 'store']);


    //Service Category
    Route::get('/service', [ServiceCategoryController::class, 'index']);
    Route::get('/service/show', [ServiceCategoryController::class, 'show']);
    Route::post('/service/store', [ServiceCategoryController::class, 'store']);
    Route::post('/service/update/{id}', [ServiceCategoryController::class, 'update']);
    Route::post('/service/delete/{id}', [ServiceCategoryController::class, 'destroy']);

    //Service SubCategory
    Route::get('/subservice', [ServiceSubCategoryController::class, 'index']);
    Route::get('/subservice/show', [ServiceSubCategoryController::class, 'show']);
    Route::post('/subservice/store', [ServiceSubCategoryController::class, 'store']);
    Route::post('/subservice/update/{id}', [ServiceSubCategoryController::class, 'update']);
    Route::post('/subservice/delete/{id}', [ServiceSubCategoryController::class, 'destroy']);

    //Occupation
    Route::get('/occupation', [OccupationController::class, 'index']);
    Route::get('/occupation/show', [OccupationController::class, 'show']);
    Route::post('/occupation/store', [OccupationController::class, 'store']);
    Route::post('/occupation/update/{id}', [OccupationController::class, 'update']);
    Route::post('/occupation/delete/{id}', [OccupationController::class, 'destroy']);

    //Blood Group
    Route::prefix('blood')->group(function(){
        Route::get('/get', [BloodGroupController::class, 'index']);
        Route::get('/show', [BloodGroupController::class, 'show']);
        Route::post('/store', [BloodGroupController::class, 'store']);
        Route::post('/update/{id}', [BloodGroupController::class, 'update']);
        Route::post('/delete/{id}', [BloodGroupController::class, 'destroy']);
    });
    
    //State
    Route::prefix('state')->group(function(){
        Route::get('/', [StateController::class, 'index']);
        Route::get('/show', [StateController::class, 'show']);
        Route::post('/store', [StateController::class, 'store']);
        Route::post('/update/{id}', [StateController::class, 'update']);
        Route::post('/delete/{id}', [StateController::class, 'destroy']);
    });

    //Country
    Route::prefix('country')->group(function(){
        Route::get('/', [CountryController::class, 'index']);
        Route::post('/show', [CountryController::class, 'show']);
        Route::post('/store', [CountryController::class, 'store']);
        Route::post('/update/{id}', [CountryController::class, 'update']);
        Route::post('/delete/{id}', [CountryController::class, 'destroy']);
    });

    //Degree
    Route::prefix('degree')->group(function(){
        Route::get('/', [DegreeController::class, 'index']);
        Route::post('/show', [DegreeController::class, 'show']);
        Route::post('/store', [DegreeController::class, 'store']);
        Route::post('/update/{id}', [DegreeController::class, 'update']);
        Route::post('/delete/{id}', [DegreeController::class, 'destroy']);

    });

    //PIB
    Route::get('/index', [PibFormulaController::class, 'index']);

    //PIT
    Route::get('/index', [PitFormulaController::class, 'index']);

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

});


/***********************************************************************************
 * Therapist API Routes
 ***********************************************************************************/
Route::get('therapist/login', [TherapistController::class, "showLogin"]);
Route::post('therapist/login', [TherapistController::class, "login"]);

Route::post('therapist/forget-password', [TherapistController::class, "forgetPassword"]);
Route::post('therapist/password-reset', [TherapistController::class, "passwordReset"]);

/**
 * Therapist Authentication
 */
Route::middleware(["auth:therapist"])->prefix("therapist")->group(function(){
    Route::get('', [TherapistController::class, 'index']);
    Route::get('/profile', [TherapistController::class, 'getProfile']);
    Route::post('profile/update', [TherapistController::class, 'updateProfile']);
    Route::post('/logout',[TherapistController::class,'logout']);

   
    /**
     * Therapist Tickets
     */
    Route::prefix('ticket')->group(function(){
        Route::get('/', [TicketController::class, 'index']);
        Route::get('/show', [TicketController::class, 'show']);
        Route::post('/store', [TicketController::class, 'store']);
        Route::post('/update', [TicketController::class, 'update']);
        Route::get('/tickethistory', [TicketController::class, 'ticketHistoryActivity']);
        Route::get('/tickethistoryshow', [TicketController::class, 'ticketHistoryActivityshow']);
        Route::post('/therapistuploaddelete', [TherapistController::class, 'deleteFileTherapist']);
        Route::post('/delete/{id}', [TherapistTicketController::class, 'deleteTicket']);
    });
    
    // Reply On Ticket
    Route::prefix("reply")->group(function(){
        Route::get('/', [TicketController::class, 'replyList']);
        Route::post('/create', [TicketController::class, 'addReply']);
        Route::get('/edit', [TicketController::class, 'editReply']);
        Route::post('/update', [TicketController::class, 'updateReply']);
        Route::get('/delete', [TicketController::class, 'deleteReply']);
    });
    
    Route::prefix('appointment')->group(function(){
        Route::get('/', [TherapistAppointmentController::class, 'index']);
        Route::get('/show', [TherapistAppointmentController::class, 'show']);
        Route::post('/store', [TherapistAppointmentController::class, 'store']);
        Route::post('/update', [TherapistAppointmentController::class, 'update']);
        Route::post('ticketstatus', [TherapistAppointmentController::class, 'appointmentstatus']);
        Route::post('/delete', [TherapistAppointmentController::class, 'destroy']);
    });
    
});


/***********************************************************************************
 * Patient API Routes
 ***********************************************************************************/
Route::get('patient/login', [PatientController::class, "showLogin"]);
Route::post('patient/login', [PatientController::class, "login"]);
Route::post('patient/forget-password', [PatientController::class, "forgetPassword"]);
Route::post('patient/password-reset', [PatientController::class, "passwordReset"]);
/**
 * Patient Authentication
 */
Route::middleware(["auth:patient"])->prefix("patient")->group(function(){
    
    Route::post('logout', [PatientController::class, "logout"]);
    Route::get('/', [PatientController::class, 'index']);
    Route::get('/show', [PatientController::class, 'show']);
    Route::post('/store', [PatientController::class, 'store']);
    Route::post('/update', [PatientController::class, 'update']);
    Route::post('/delete', [PatientController::class, 'destroy']);
    
            Route::prefix('ticket')->group(function(){ 
                Route::get('/', [TicketController::class, 'index']);
                Route::post('/create', [TicketController::class, 'store']);
                Route::get('/show', [TicketController::class, 'show']);
                Route::post('/update', [TicketController::class, 'update']);
                Route::post('/delete', [TicketController::class, 'deleteTicket']);
                Route::post('/cancelticket', [TicketController::class, 'cancelticket']);
                Route::post('/assignedticket', [TicketController::class, 'assignedticket']);
                Route::post('/ticketuploaddelete', [TicketController::class, 'deleteFileTicket']);
            });
           

            // Reply On Ticket
            Route::prefix("reply")->group(function(){
                Route::get('/', [TicketController::class, 'replyList']);
                Route::post('/create', [TicketController::class, 'addReply']);
                Route::get('/edit', [TicketController::class, 'editReply']);
                Route::post('/update', [TicketController::class, 'updateReply']);
                Route::get('/delete', [TicketController::class, 'deleteReply']);
            });
    
    
    // Appointment
    Route::prefix('appointment')->group(function(){
        Route::get('/', [AppointmentController::class, 'index']);
        Route::get('/show', [AppointmentController::class, 'show']);
        Route::post('/store', [AppointmentController::class, 'store']);
        Route::post('/update', [AppointmentController::class, 'update']);
        Route::post('ticketstatus', [AppointmentController::class, 'appointmentstatus']);
        Route::post('/delete', [AppointmentController::class, 'destroy']);
    });
});


