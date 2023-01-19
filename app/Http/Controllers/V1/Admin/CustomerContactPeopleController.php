<?php

namespace App\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerContactPeople;
use App\Http\Resources\CustomerContactPeopleResource;
use Exception;
use Illuminate\Support\Facades\Validator;

class CustomerContactPeopleController extends Controller
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
            $this->data = CustomerContactPeopleResource::collection(CustomerContactPeople::all());
            $this->apiSuccess("Vendor Contact People Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $customer_contact = CustomerContactPeople::find($request->id);
            if( empty($customer_contact) ){
                return $this->apiOutput("Customer Contact People Data Not Found", 400);
            }
            $this->data = (new CustomerContactPeopleResource ($customer_contact));
            $this->apiSuccess("Customer Contact People Detail Show Successfully");
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
                    "customer_id"                 => ["required"],
                    "employee_id"                 => ["required"],
                    "status"                      => 'required',
                ]);

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $customer_contact = new CustomerContactPeople();
                $customer_contact->customer_id     = $request->customer_id;
                $customer_contact->employee_id     = $request->employee_id;
                $customer_contact->first_name      = $request->first_name;
                $customer_contact->last_name       = $request->last_name;
                $customer_contact->designation     = $request->designation;
                $customer_contact->department      = $request->department;
                $customer_contact->category        = $request->category;
                $customer_contact->phone           = $request->phone;
                $customer_contact->email           = $request->email;



                $customer_contact->remarks         = $request->remarks;
                $customer_contact->status          = $request->status;
                $customer_contact->created_at      = $request->created_at;
                $customer_contact->updated_at      = $request->updated_at;
                $customer_contact->deleted_by      = $request->deleted_by;
                $customer_contact->deleted_date    = $request->deleted_date;

                $customer_contact->save();

            try{
                event(new CustomerContactPeopleResource($customer_contact));
            }catch(Exception $e){

            }
            $this->apiSuccess("Customer Contact People Added Successfully");
            $this->data = (new CustomerContactPeopleResource($customer_contact));
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request,$id)
    {
        try{
        $validator = Validator::make($request->all(),[
            "customer_id"                 => ["required"],
            "employee_id"                 => ["required"],
            "status"                      => 'required',
        ]);

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $customer_contact = CustomerContactPeople::find($request->id);
            $customer_contact->customer_id     = $request->customer_id;
            $customer_contact->employee_id     = $request->employee_id;
            $customer_contact->first_name      = $request->first_name;
            $customer_contact->last_name       = $request->last_name;
            $customer_contact->designation     = $request->designation;
            $customer_contact->department      = $request->department;
            $customer_contact->category        = $request->category;
            $customer_contact->phone           = $request->phone;
            $customer_contact->email           = $request->email;



            $customer_contact->remarks         = $request->remarks;
            $customer_contact->status          = $request->status;
            $customer_contact->created_at      = $request->created_at;
            $customer_contact->updated_at      = $request->updated_at;
            $customer_contact->deleted_by      = $request->deleted_by;
            $customer_contact->deleted_date    = $request->deleted_date;

            $customer_contact->save();
            $this->apiSuccess("Customer Contact Updated Successfully");
            $this->data = (new CustomerContactPeopleResource($customer_contact));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function destroy(Request $request,$id)
    {
        $customer_contact = CustomerContactPeople::find($request->id);
        $customer_contact->delete();
        $this->apiSuccess();
        return $this->apiOutput("Customer Contact People Deleted Successfully", 200);
    }

}
