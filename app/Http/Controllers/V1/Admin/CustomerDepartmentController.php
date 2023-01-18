<?php

namespace App\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use App\Models\CustomerDepartment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerDepartmentResource;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerDepartmentController extends Controller
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
            $this->data = CustomerDepartmentResource::collection(CustomerDepartment::all());
            $this->apiSuccess("Customer Department Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $customer_department = CustomerDepartment::find($request->id);
            if( empty($customer_department) ){
                return $this->apiOutput("Customer Department Data Not Found", 400);
            }
            $this->data = (new CustomerDepartmentResource ($customer_department));
            $this->apiSuccess("Customer Department Detail Show Successfully");
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
                    "status"                      => 'required',
                ] );

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                DB::beginTransaction();
                $customer_department = new CustomerDepartment();

                $customer_department->customer_id     = $request->customer_id;
                $customer_department->department_name = $request->department_name;
                $customer_department->image           = $this->uploadFileNid($request, 'image', $this->customer_department_image, 720);
                $customer_department->contact_number  = $request->contact_number;
                $customer_department->email           = $request->email;
                $customer_department->address         = $request->address;

                $customer_department->remarks         = $request->remarks;
                $customer_department->status          = $request->status;
                $customer_department->created_at      = $request->created_at;
                $customer_department->updated_at      = $request->updated_at;
                $customer_department->deleted_by      = $request->deleted_by;
                $customer_department->deleted_date    = $request->deleted_date;

                $customer_department->save();
                DB::commit();

            try{
                event(new CustomerDepartmentResource($customer_department));
            }catch(Exception $e){

            }
            $this->apiSuccess("Customer Department Added Successfully");
            $this->data = (new CustomerDepartmentResource($customer_department));
            return $this->apiOutput();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request)
    {
        try{
        $validator = Validator::make($request->all(),[
            "customer_id"                 => ["required"],
            "status"                      => 'required',
        ]);

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            DB::beginTransaction();
            $customer_department = CustomerDepartment::find($request->id);
            $customer_department->customer_id     = $request->customer_id;
            $customer_department->department_name = $request->department_name;
            $customer_department->image           = $this->uploadFileNid($request, 'image', $this->customer_department_image, 720);
            $customer_department->contact_number  = $request->contact_number;
            $customer_department->email           = $request->email;
            $customer_department->address         = $request->address;

            $customer_department->remarks         = $request->remarks;
            $customer_department->status          = $request->status;
            $customer_department->created_at      = $request->created_at;
            $customer_department->updated_at      = $request->updated_at;
            $customer_department->deleted_by      = $request->deleted_by;
            $customer_department->deleted_date    = $request->deleted_date;

            $customer_department->save();
            DB::commit();

            $this->apiSuccess("Customer Department Updated Successfully");
            $this->data = (new CustomerDepartmentResource($customer_department));
            return $this->apiOutput();
        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

     /*
       Delete
    */
    public function delete(Request $request)
    {
        CustomerDepartment::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Customer Department Deleted Successfully", 200);
    }
}
