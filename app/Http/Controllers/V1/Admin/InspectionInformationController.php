<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InspectionInformationResource;
use App\Models\InspectionInformation;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class InspectionInformationController extends Controller
{

    public function index()
    {
       try{
        //return 10;
            // if(!PermissionController::hasAccess("group_list")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }
            $this->data = InspectionInformationResource::collection(InspectionInformation::all());
            $this->apiSuccess("Inspection Information Loaded Successfully");
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
                'name'          => ["required", "min:4"],
                'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $inspection = new InspectionInformation();
            $inspection->po_number = $request->po_number;
            $inspection->po_id = $request->po_id;
            $inspection->sewing_inline_inspection_date_plan = $request->sewing_inline_inspection_date_plan;
            $inspection->sewing_inline_inspection_date_actual = $request->sewing_inline_inspection_date_actual;
            $inspection->inline_inspection_schedule = $request->inline_inspection_schedule;
            $inspection->finishing_inline_inspection_date_plan = $request->finishing_inline_inspection_date_plan;
            $inspection->finishing_inline_inspection_date_actual = $request->finishing_inline_inspection_date_actual;
            $inspection->pre_final_date_actual = $request->pre_final_date_actual;
            $inspection->pre_final_aql_schedule = $request->pre_final_aql_schedule;
            $inspection->final_aql_date_plan = $request->final_aql_date_plan;
            $inspection->final_aql_date_actual = $request->final_aql_date_actual;
            $inspection->final_aql_schedule=$request->final_aql_schedule;
            $inspection->save();
            $this->apiSuccess();
            $this->data = (new InspectionInformationResource($inspection));
            return $this->apiOutput("Inspection Information Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request){
        try{

            // if(!PermissionController::hasAccess("group_create")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }

            $validator = Validator::make( $request->all(),[
                'name'          => ["required", "min:4"],
                'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $inspection = InspectionInformation::find($request->id);
            $inspection->po_number = $request->po_number;
            $inspection->po_id = $request->po_id;
            $inspection->sewing_inline_inspection_date_plan = $request->sewing_inline_inspection_date_plan;
            $inspection->sewing_inline_inspection_date_actual = $request->sewing_inline_inspection_date_actual;
            $inspection->inline_inspection_schedule = $request->inline_inspection_schedule;
            $inspection->finishing_inline_inspection_date_plan = $request->finishing_inline_inspection_date_plan;
            $inspection->finishing_inline_inspection_date_actual = $request->finishing_inline_inspection_date_actual;
            $inspection->pre_final_date_actual = $request->pre_final_date_actual;
            $inspection->pre_final_aql_schedule = $request->pre_final_aql_schedule;
            $inspection->final_aql_date_plan = $request->final_aql_date_plan;
            $inspection->final_aql_date_actual = $request->final_aql_date_actual;
            $inspection->final_aql_schedule=$request->final_aql_schedule;
            $inspection->save();
            $this->apiSuccess();
            $this->data = (new InspectionInformationResource($inspection));
            return $this->apiOutput("Inspection Information Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            // if(!PermissionController::hasAccess("group_show")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }
            $inspection = InspectionInformation::find($request->id);
            $this->data = (new InspectionInformationResource($inspection));
            $this->apiSuccess("Inspection Information Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function delete(Request $request)
    {
        InspectionInformation::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Inspection Information Deleted Successfully", 200);
    }

}
