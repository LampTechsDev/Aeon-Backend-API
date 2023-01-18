<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Events\AccountRegistration;
use App\Models\VendorContactPeople;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VendorContactPeopleResource;

class VendorContactPeopleController extends Controller
{
     /**
    * Show Login
    */
   public function showLogin(Request $request){
    $this->data = [
        "email"     => "required",
        "password"  => "required",
    ];
    $this->apiSuccess("This credentials are required for Login ");
    return $this->apiOutput(200);
   }



    public function index()
    {
        try{
            $this->data = VendorContactPeopleResource::collection(VendorContactPeople::all());
            $this->apiSuccess("Vendor Contact People Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $vendor = VendorContactPeople::find($request->id);
            if( empty($vendor) ){
                return $this->apiOutput("Vendor Contact People Data Not Found", 400);
            }
            $this->data = (new VendorContactPeopleResource ($vendor));
            $this->apiSuccess("Vendor Contact People Detail Show Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request)
    {

        try{
            $validator = Validator::make(
                $request->all(),
                [
                    "vendor_id"          => ["required"],
                    "employee_id"          => ["required"],
                    "email"                => ["required","email"],
                    "status"               => 'required',

                ],[
                    // "group_id.exists"     => "No Record found under this group",
                ]
            );

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $vendor_contact_people = new VendorContactPeople();
                $vendor_contact_people->vendor_id = $request->vendor_id;
                $vendor_contact_people->employee_id = $request->employee_id;
                $vendor_contact_people->first_name = $request->first_name;
                $vendor_contact_people->last_name = $request->last_name;
                $vendor_contact_people->designation = $request->designation;
                $vendor_contact_people->department = $request->department;
                $vendor_contact_people->category = $request->category;
                $vendor_contact_people->phone = $request->phone;
                $vendor_contact_people->email = $request->email;
                $vendor_contact_people->remarks = $request->remarks;
                $vendor_contact_people->status = $request->status;
                $vendor_contact_people->created_at = $request->created_at;
                $vendor_contact_people->updated_at = $request->updated_at;
                $vendor_contact_people->deleted_by = $request->deleted_by;
                $vendor_contact_people->deleted_date = $request->deleted_date;
                $vendor_contact_people->save();

            try{
                event(new AccountRegistration($vendor_contact_people));
            }catch(Exception $e){

            }
            $this->apiSuccess("Vendor Contact People Added Successfully");
            $this->data = (new VendorContactPeopleResource($vendor_contact_people));
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request,$id)
    {
        try{
        $validator = Validator::make($request->all(),[
        "id"                   => ["required"],
        "vendor_id"            => ["required"],
        "employee_id"          => ["required"],
        "email"                => ["required","email"],
        "status"               => 'required',
        ] );

        if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
        }

            $vendor_contact_people = VendorContactPeople::find($request->id);

            $vendor_contact_people->vendor_id = $request->vendor_id;
            $vendor_contact_people->employee_id = $request->employee_id;
            $vendor_contact_people->first_name = $request->first_name;
            $vendor_contact_people->last_name = $request->last_name;
            $vendor_contact_people->designation = $request->designation;
            $vendor_contact_people->department = $request->department;
            $vendor_contact_people->category = $request->category;
            $vendor_contact_people->phone = $request->phone;
            $vendor_contact_people->email = $request->email;
            $vendor_contact_people->remarks = $request->remarks;
            $vendor_contact_people->status = $request->status;
            $vendor_contact_people->created_at = $request->created_at;
            $vendor_contact_people->updated_at = $request->updated_at;
            $vendor_contact_people->deleted_by = $request->deleted_by;
            $vendor_contact_people->deleted_date = $request->deleted_date;

            $vendor_contact_people->save();
            $this->apiSuccess("Vendor Contact People Updated Successfully");
            $this->data = (new VendorContactPeopleResource($vendor_contact_people));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function destroy(Request $request,$id)
    {
        $vendor_contact_people = VendorContactPeople::find($request->id);
        $vendor_contact_people->delete();
        $this->apiSuccess();
        return $this->apiOutput("Vendor Contact People Deleted Successfully", 200);
    }
}
