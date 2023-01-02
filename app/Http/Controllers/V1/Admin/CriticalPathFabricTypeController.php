<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CriticalPathFabricTypeResource;
use App\Models\CriticalPathFabricType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CriticalPathFabricTypeController extends Controller
{
    public function index(){
        try{
                
                $this->data = CriticalPathFabricTypeResource::collection(CriticalPathFabricType::all());
                $this->apiSuccess("Critical Path Fabric Type Loaded Successfully");
                return $this->apiOutput();
    
            }catch(Exception $e){
                return $this->apiOutput($this->getError($e), 500);
            }
    }

    public function store(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $criticalPathFabricType = new CriticalPathFabricType();
            $criticalPathFabricType->name=$request->name;
            $criticalPathFabricType->days=$request->days;
            $criticalPathFabricType->status=$request->status;
            $criticalPathFabricType->save();
            $this->apiSuccess();
            $this->data = (new CriticalPathFabricTypeResource($criticalPathFabricType));
            return $this->apiOutput("Critical Path FabricType Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function update(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $criticalPathFabricType = CriticalPathFabricType::find($request->id);
            $criticalPathFabricType->name=$request->name;
            $criticalPathFabricType->days=$request->days;
            $criticalPathFabricType->status=$request->status;
            $criticalPathFabricType->save();
            $this->apiSuccess();
            $this->data = (new CriticalPathFabricTypeResource($criticalPathFabricType));
            return $this->apiOutput("Critical Path Fabric Type Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            
            $criticalPathFabricType = CriticalPathFabricType::find($request->id);
            $this->data = (new CriticalPathFabricTypeResource($criticalPathFabricType));
            $this->apiSuccess("Critical Path Fabric Type Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

     /*
       Delete
    */
    public function delete(Request $request)
    {
        CriticalPathFabricType::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Critical Path FabricType Deleted Successfully", 200);
    }
}
