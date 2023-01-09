<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PpMeetingResource;
use App\Models\PpMeeting;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class PpMeetingController extends Controller
{
    public function store(Request $request){
        try{

            // if(!PermissionController::hasAccess("group_create")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $ppMeeting = new PpMeeting();
            $ppMeeting->care_label_approval_plan = $request->care_label_approval_plan;
            $ppMeeting->care_label_approval_actual = $request->care_label_approval_actual;
            $ppMeeting->material_inhouse_date_plan = $request->material_inhouse_date_plan;
            $ppMeeting->material_inhouse_date_actual = $request->material_inhouse_date_actual;
            $ppMeeting->pp_meeting_date_plan = $request->pp_meeting_date_plan;
            $ppMeeting->pp_meeting_date_actual = $request->pp_meeting_date_actual;
            $ppMeeting->pp_meeting_schedule = $request->pp_meeting_schedule;
            $ppMeeting->save();
            $this->apiSuccess();
            $this->data = (new PpMeetingResource($ppMeeting));
            return $this->apiOutput("PpMeeting Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
