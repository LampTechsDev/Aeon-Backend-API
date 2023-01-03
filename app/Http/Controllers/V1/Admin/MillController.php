<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MillResource;
use App\Models\Mill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class MillController extends Controller
{

    public function index()
    {
       try{
    
            $this->data = MillResource::collection(Mill::all());
            $this->apiSuccess("Mill Loaded Successfully");
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
   
            $mill = new Mill();
            $mill->name = $request->name ;
            $mill->remarks = $request->remarks;
            $mill->status = $request->status;
            $mill->save();
            $this->apiSuccess();
            $this->data = (new MillResource($mill));
            return $this->apiOutput("Mill Added Successfully");
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
   
            $mill = Mill::find($request->id);
            $mill->name = $request->name ;
            $mill->remarks = $request->remarks;
            $mill->status = $request->status;
            $mill->save();
            $this->apiSuccess();
            $this->data = (new MillResource($mill));
            return $this->apiOutput("Mill Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
          
            $mill = Mill::find($request->id);
            $this->data = (new MillResource($mill));
            $this->apiSuccess("Mill Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function delete(Request $request)
    {
        Mill::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Mill Deleted Successfully", 200);
    }
 }
