<?php

namespace App\Http\Controllers\V1\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use Exception;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
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
        $this->data = CustomerResource::collection(Customer::all());
        $this->apiSuccess("Vendor Contact People Load has been Successfully done");
        return $this->apiOutput();

    }catch(Exception $e){
        return $this->apiOutput($this->getError($e), 500);
    }
}

public function show(Request $request)
{
    try{
        $vendor = Customer::find($request->id);
        if( empty($vendor) ){
            return $this->apiOutput("Vendor Contact People Data Not Found", 400);
        }
        $this->data = (new CustomerResource ($vendor));
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
                "name"                 => ["required"],
                "email"                => ["required","email"],
                "status"               => 'required',

            ],[
                // "group_id.exists"     => "No Record found under this group",
            ]
           );

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 400);
            }
            $customer = new Customer();

            $customer->name            = $request->name;
            $customer->logo            = $this->uploadFileNid($request, 'logo', $this->customer_logo, 720);
            $customer->address         = $request->address;
            $customer->email           = $request->email;
            $customer->contact_number  = $request->contact_number;
            $customer->remarks         = $request->remarks;
            $customer->status          = $request->status;
            $customer->created_at      = $request->created_at;
            $customer->updated_at      = $request->updated_at;
            $customer->deleted_by      = $request->deleted_by;
            $customer->deleted_date    = $request->deleted_date;

            $customer->save();

        try{
            event(new CustomerResource($customer));
        }catch(Exception $e){

        }
        $this->apiSuccess("Customer Added Successfully");
        $this->data = (new CustomerResource($customer));
        return $this->apiOutput();

    }catch(Exception $e){
        return $this->apiOutput($this->getError( $e), 500);
    }
}

public function update(Request $request,$id)
{
    try{
    $validator = Validator::make($request->all(),[
        "name"                 => ["required"],
        "email"                => ["required","email"],
        "status"               => 'required',
    ]);

       if ($validator->fails()) {
        $this->apiOutput($this->getValidationError($validator), 400);
       }

        $customer = Customer::find($request->id);
        $customer->name            = $request->name;
        $customer->logo            = $this->uploadFileNid($request, 'logo', $this->customer_logo, 720);
        $customer->address         = $request->address;
        $customer->email           = $request->email;
        $customer->contact_number  = $request->contact_number;
        $customer->remarks         = $request->remarks;
        $customer->status          = $request->status;
        $customer->created_at      = $request->created_at;
        $customer->updated_at      = $request->updated_at;
        $customer->deleted_by      = $request->deleted_by;
        $customer->deleted_date    = $request->deleted_date;

        $customer->save();
        $this->apiSuccess("Customer Updated Successfully");
        $this->data = (new CustomerResource($customer));
        return $this->apiOutput();
    }catch(Exception $e){
        return $this->apiOutput($this->getError( $e), 500);
    }
}

public function destroy(Request $request,$id)
{
    $customer = Customer::find($request->id);
    $customer->delete();
    $this->apiSuccess();
    return $this->apiOutput("Customer Deleted Successfully", 200);
}
}
