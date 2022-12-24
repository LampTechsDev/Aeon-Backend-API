<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FabricQualityResource;
use App\Models\FabricQuality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class FabricQualityController extends Controller
{
    public function index()
    {
       try{

            $this->data = FabricQualityResource::collection(FabricQuality::all());
            $this->apiSuccess("Fabric Content Loaded Successfully");
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
   
            $fabricquality = new FabricQuality();
            $fabricquality->name = $request->name ;
            $fabricquality->details = $request->details;
            $fabricquality->status = $request->status;
            $fabricquality->fabric_content_id =$request->fabric_content_id;
            $fabricquality->save();
            $this->apiSuccess();
            $this->data = (new FabricQualityResource($fabricquality));
            return $this->apiOutput("Fabric Quality Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function show(Request $request)
    {
        try{
            
            $fabricquality = FabricQuality::find($request->id);
           
            $this->data = (new FabricQualityResource($fabricquality));
            $this->apiSuccess("Fabric Content Showed Successfully");
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
   
            
            $fabricquality =  FabricQuality::find($request->id);
            $fabricquality->name = $request->name ;
            $fabricquality->details = $request->details;
            $fabricquality->status = $request->status;
            $fabricquality->fabric_content_id =$request->fabric_content_id;
            $fabricquality->save();
            $this->apiSuccess();
            $this->data = (new FabricQualityResource($fabricquality));
            return $this->apiOutput("Fabric Content Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function delete(Request $request)
    {
        FabricQuality::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Fabric Deleted Successfully", 200);
    }
}
