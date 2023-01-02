<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CriticalPathDepartmentResource;
use App\Models\CriticalPathDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CriticalPathDepartmentController extends Controller
{

    public function index(){
        try{
                
                $this->data = CriticalPathDepartmentResource::collection(CriticalPathDepartment::all());
                $this->apiSuccess("Critical Path Department Loaded Successfully");
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
   
            $criticalPathDepartment = new CriticalPathDepartment();
            $criticalPathDepartment->name=$request->name;
            $criticalPathDepartment->days=$request->days;
            $criticalPathDepartment->status=$request->status;
            $criticalPathDepartment->save();
            $this->apiSuccess();
            $this->data = (new CriticalPathDepartmentResource($criticalPathDepartment));
            return $this->apiOutput("Critical Path Department Added Successfully");
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
   
            $criticalPathDepartment = CriticalPathDepartment::find($request->id);
            $criticalPathDepartment->name=$request->name;
            $criticalPathDepartment->days=$request->days;
            $criticalPathDepartment->status=$request->status;
            $criticalPathDepartment->save();
            $this->apiSuccess();
            $this->data = (new CriticalPathDepartmentResource($criticalPathDepartment));
            return $this->apiOutput("Critical Path Department Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            
            $criticalPathDepartment = CriticalPathDepartment::find($request->id);
            $this->data = (new CriticalPathDepartmentResource($criticalPathDepartment));
            $this->apiSuccess("Critical Path Department Showed Successfully");
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
        CriticalPathDepartment::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Critical Path Department Deleted Successfully", 200);
    }
}
