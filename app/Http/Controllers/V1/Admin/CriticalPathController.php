<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CriticalPathResource;
use App\Models\CriticalPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CriticalPathController extends Controller
{
    public function store(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $criticalPath = new CriticalPath();
            $criticalPath->po_id=$request->po_id;
            $criticalPath->labdips_embellishment_id=$request->labdips_embellishment_id;
            $criticalPath->bulk_fabric_information_id =$request->bulk_fabric_information_id;
            $criticalPath->fabric_mill_id = $request->fabric_mill_id;
            $criticalPath->	lead_times=$request->lead_times;
            $criticalPath->lead_type=$request->lead_type;
            $criticalPath->	official_po_plan=$request->official_po_plan;
            $criticalPath->official_po_actual=$request->official_po_actual;
            $criticalPath->status=$request->status;
            $criticalPath->save();
            $this->apiSuccess();
            $this->data = (new CriticalPathResource($criticalPath));
            return $this->apiOutput("Critical Path Department Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
