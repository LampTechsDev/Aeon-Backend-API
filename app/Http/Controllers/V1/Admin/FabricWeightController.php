<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FabricWeightResource;
use App\Models\FabricWeight;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class FabricWeightController extends Controller
{
    public function index()
    {
       try{

            $this->data = FabricWeightResource::collection(FabricWeight::all());
            $this->apiSuccess("Fabric Weight Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request)
    {
     
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $fabricweight = new FabricWeight();
            $fabricweight->name = $request->name ;
            $fabricweight->details = $request->details;
            $fabricweight->status = $request->status;
            $fabricweight->fabric_content_id =$request->fabric_content_id;
            $fabricweight->save();
            $this->apiSuccess();
            $this->data = (new FabricWeightResource($fabricweight));
            return $this->apiOutput("Fabric Weight Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function show(Request $request)
    {
        try{
            
            $fabricweight = FabricWeight::find($request->id);
           
            $this->data = (new FabricWeightResource($fabricweight));
            $this->apiSuccess("Fabric Weight Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }


    public function update(Request $request)
    {
     
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            
            $fabricweight =  FabricWeight::find($request->id);
            $fabricweight->name = $request->name ;
            $fabricweight->details = $request->details;
            $fabricweight->status = $request->status;
            $fabricweight->fabric_content_id =$request->fabric_content_id;
            $fabricweight->save();
            $this->apiSuccess();
            $this->data = (new FabricWeightResource($fabricweight));
            return $this->apiOutput("Fabric Weight Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function delete(Request $request)
    {
        FabricWeight::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Fabric Weight Deleted Successfully", 200);
    }
}
