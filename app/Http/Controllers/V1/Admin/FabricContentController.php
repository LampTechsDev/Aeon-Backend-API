<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FabricContentResource;
use App\Models\FabricContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class FabricContentController extends Controller
{
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
   
            $fabriccontent = new FabricContent();
            $fabriccontent->name = $request->name ;
            $fabriccontent->details = $request->details;
            $fabriccontent->status = $request->status;
            $fabriccontent->save();
            $this->apiSuccess();
            $this->data = (new FabricContentResource($fabriccontent));
            return $this->apiOutput("Fabric Content Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function show(Request $request)
    {
        try{
            
            $fabriccontent = FabricContent::find($request->id);
           
            $this->data = (new FabricContentResource($fabriccontent));
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
   
            
            $fabriccontent =  FabricContent::find($request->id);
            $fabriccontent->name = $request->name ;
            $fabriccontent->details = $request->details;
            $fabriccontent->status = $request->status;
            $fabriccontent->save();
            $this->apiSuccess();
            $this->data = (new FabricContentResource($fabriccontent));
            return $this->apiOutput("Fabric Content Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
