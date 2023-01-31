<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CriticalPathResource;
use App\Http\Resources\FreightManagementResource;
use App\Models\CriticalPath;
use App\Models\FreightManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;


class FreightManagementController extends Controller
{

    public function index()
    {
       try{
        //return 10;
            // if(!PermissionController::hasAccess("group_list")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }
            $this->data = FreightManagementResource::collection(FreightManagement::all());
            $this->apiSuccess("Freight Management Details List Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }


    /*public function store(Request $request)
    {
        
     
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

            $inspection = new FreightManagement();
            $inspection->critical_path_id = $request->critical_path_id;
            $inspection->save();

            DB::commit();
            $this->apiSuccess();
            $this->data = (new InspectionOrderDetailsResource($inspection));
            return $this->apiOutput("Inspection Management Order Details Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }*/

  public function update(Request $request)
   {
     
      try{

            // if(!PermissionController::hasAccess("group_create")){
            //      return $this->apiOutput("Permission Missing", 403);
            // }

           $validator = Validator::make( $request->all(),[
               // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

             $freight = FreightManagement::find($request->id);
             //$freight->critical_path_id = $request->critical_path_id;
             $freight->remarks = $request->remarks;
             $freight->save();

            DB::commit();
           $this->apiSuccess();
           $this->data = (new FreightManagementResource($freight));
            return $this->apiOutput("Inspection Management Order Details Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


     /*
    Show
    */
    public function show(Request $request)
    {
        try{
            
            $freight = FreightManagement::find($request->id);
            $this->data = (new FreightManagementResource($freight));
            $this->apiSuccess("Freight Management Details Show Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    // public function delete(Request $request)
    // {
    //     InspectionManagementOrderDetails::where("id", $request->id)->delete();
    //     $this->apiSuccess();
    //     return $this->apiOutput("Inspection Management Order Details Dleted Successfully", 200);
    // }
}
