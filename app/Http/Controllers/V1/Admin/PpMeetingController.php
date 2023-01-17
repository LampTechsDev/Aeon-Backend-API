<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PpMeetingResource;
use App\Models\PpMeeting;
use App\Models\PpMeetingReportUpload;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PpMeetingController extends Controller
{
    public function index()
    {
       try{
    
            $this->data = PpMeetingResource::collection(PpMeeting::all());
            $this->apiSuccess("PP Meeting Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

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
            DB::beginTransaction();

            $ppMeeting = new PpMeeting();
            $ppMeeting->po_id=$request->po_id;
            $ppMeeting->po_number=$request->po_number;
            $ppMeeting->care_label_approval_plan = $request->care_label_approval_plan;
            $ppMeeting->care_label_approval_actual = $request->care_label_approval_actual;
            $ppMeeting->material_inhouse_date_plan = $request->material_inhouse_date_plan;
            $ppMeeting->material_inhouse_date_actual = $request->material_inhouse_date_actual;
            $ppMeeting->pp_meeting_date_plan = $request->pp_meeting_date_plan;
            $ppMeeting->pp_meeting_date_actual = $request->pp_meeting_date_actual;
            $ppMeeting->pp_meeting_schedule = $request->pp_meeting_schedule;
            $ppMeeting->save();
            $this->saveFileInfo($request, $ppMeeting);

            DB::commit();
            $this->apiSuccess();
            $this->data = (new PpMeetingResource($ppMeeting));
            return $this->apiOutput("PP Meeting Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    // Save File Info
    public function saveFileInfo($request, $ppMeeting){
        $file_path = $this->uploadFile($request, 'file', $this->pogarments_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PpMeetingReportUpload();
            $data->pp_meeting_id = $ppMeeting->id;
            $data->file_name    = $request->file_name ?? "PP_Meeting_Report_Upload";
            $data->file_url     = $path;
            $data->type = $request->type;
            $data->save();
        }
    }

    public function update(Request $request){
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
   
            $ppMeeting = PpMeeting::find($request->id);
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
            return $this->apiOutput("PP Meeting Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
          
            $ppMeeting = PpMeeting::find($request->id);
            $this->data = (new PpMeetingResource($ppMeeting));
            $this->apiSuccess("PP Meeting Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function delete(Request $request)
    {
        PpMeeting::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("PP Meeting Deleted Successfully", 200);
    }
}
