<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AeonContactResource;
use App\Models\AeonContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class AeonContactController extends Controller
{

    public function index(){
        try{
                
                $this->data = AeonContactResource::collection(AeonContact::all());
                $this->apiSuccess("Aeon Contact Loaded Successfully");
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
   
            $aeon = new AeonContact();
            $aeon->aeon_id = $request->aeon_id;
            $aeon->employee_id = $request->employee_id;
            $aeon->first_name = $request->first_name;
            $aeon->last_name = $request->last_name;
            $aeon->designation = $request->designation;
            $aeon->department = $request->department;
            $aeon->category = $request->category;
            $aeon->phone = $request->phone;
            $aeon->email = $request->email;
            $aeon->remarks = $request->remarks;
            $aeon->status = $request->status;
            $aeon->save();
            $this->apiSuccess();
            $this->data = (new AeonContactResource($aeon));
            return $this->apiOutput("Aeon Contact Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
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
   
            $aeon = AeonContact::find($request->id);
            $aeon->aeon_id = $request->aeon_id;
            $aeon->employee_id = $request->employee_id;
            $aeon->first_name = $request->first_name;
            $aeon->last_name = $request->last_name;
            $aeon->designation = $request->designation;
            $aeon->department = $request->department;
            $aeon->category = $request->category;
            $aeon->phone = $request->phone;
            $aeon->email = $request->email;
            $aeon->remarks = $request->remarks;
            $aeon->status = $request->status;
            $aeon->save();
            $this->apiSuccess();
            $this->data = (new AeonContactResource($aeon));
            return $this->apiOutput("Aeon Contact Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            
            $aeonContact = AeonContact::find($request->id);
            $this->data = (new AeonContactResource($aeonContact));
            $this->apiSuccess("Aeon Contact Showed Successfully");
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
        AeonContact::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Aeon Contact Deleted Successfully", 200);
    }
}
