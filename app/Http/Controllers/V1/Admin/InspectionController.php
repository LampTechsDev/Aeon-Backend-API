<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InspectionResource;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class InspectionController extends Controller
{
    public function index(){
        try{
                
            $this->data = InspectionResource::collection(Inspection::all());
            $this->apiSuccess("Inspection List Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }

    }

    public function store(Request $request){

        try{
            $validator = Validator::make( $request->all(),[
                //'name'          => ["required", "min:4"],
                //'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            
   
            $inspection = new Inspection();
            $inspection->item_details_id=$request->item_details_id;
            $inspection->inspection_name = $request->inspection_name;
            $inspection->inspection_date = $request->inspection_date;
            $inspection->inspection_time = $request->inspection_time;
            $inspection->inspection_note = $request->inspection_note;
            $inspection->status = $request->status;
            $inspection->remarks=$request->remarks;
            $inspection->save();
          
            $this->apiSuccess();
            $this->data = (new InspectionResource($inspection));
            return $this->apiOutput("Inspection Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }

    }

    public function update(Request $request){

        try{
            $validator = Validator::make( $request->all(),[
                //'name'          => ["required", "min:4"],
                //'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            
   
            $inspection = Inspection::find($request->id);
            $inspection->item_details_id=$request->item_details_id;
            $inspection->inspection_name = $request->inspection_name;
            $inspection->inspection_date = $request->inspection_date;
            $inspection->inspection_time = $request->inspection_time;
            $inspection->inspection_note = $request->inspection_note;
            $inspection->status = $request->status;
            $inspection->remarks=$request->remarks;
            $inspection->save();
          
            $this->apiSuccess();
            $this->data = (new InspectionResource($inspection));
            return $this->apiOutput("Inspection Updated Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }

        
    }


    public function show(Request $request)
    {
        try{
           
            $inspection = Inspection::find($request->id);
            $this->data = (new InspectionResource($inspection));
            $this->apiSuccess("Inspection Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }


    public function delete(Request $request)
    {
        Inspection::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Inspection Deleted Successfully", 200);
    }
}
