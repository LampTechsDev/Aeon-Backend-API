<?php

namespace App\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use App\Models\CustomerDepartment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerDepartmentResource;
use Exception;
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

                ],[
                    // "group_id.exists"     => "No Record found under this group",
                ]
               );

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $customer_department = new CustomerDepartment();

                $customer_department->customer_id     = $request->customer_id;
                $customer_department->department_name = $request->department_name;
                $customer_department->image           = $request->image;
                $customer_department->contact_number  = $request->contact_number;
                $customer_department->email           = $request->email;
                $customer_department->address         = $request->address;

                $customer_department->remarks         = $request->remarks;
                $customer_department->status          = $request->status;
             //    $customer->created_by = $request->created_by;
             //    $customer->updated_by = $request->updated_by;
                $customer_department->created_at      = $request->created_at;
                $customer_department->updated_at      = $request->updated_at;
                $customer_department->deleted_by      = $request->deleted_by;
                $customer_department->deleted_date    = $request->deleted_date;

                $customer_department->save();

            try{
                event(new CustomerDepartmentResource($customer_department));
            }catch(Exception $e){

            }
            $this->apiSuccess("Customer Department Added Successfully");
            $this->data = (new CustomerDepartmentResource($customer_department));
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
            "status"                      => 'required',
        ],[
            // "id"                  => "No Data Found for this Id",
            // "group_id.exists"     => "No Record found under this group",
        ]
        );

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $customer_department = CustomerDepartment::find($request->id);
            // if(empty($admin)){
            //     return $this->apiOutput("No Data Found", $admin);
            // }

            $customer_department->customer_id     = $request->customer_id;
            $customer_department->department_name = $request->department_name;
            $customer_department->image           = $request->image;
            $customer_department->contact_number  = $request->contact_number;
            $customer_department->email           = $request->email;
            $customer_department->address         = $request->address;

            $customer_department->remarks         = $request->remarks;
            $customer_department->status          = $request->status;
         //    $customer->created_by = $request->created_by;
         //    $customer->updated_by = $request->updated_by;
            $customer_department->created_at      = $request->created_at;
            $customer_department->updated_at      = $request->updated_at;
            $customer_department->deleted_by      = $request->deleted_by;
            $customer_department->deleted_date    = $request->deleted_date;

            $customer_department->save();

            $this->apiSuccess("Customer Department Updated Successfully");
            $this->data = (new CustomerDepartmentResource($customer_department));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function destroy(Request $request,$id)
    {
        $customer_department = CustomerDepartment::find($request->id);
        $customer_department->delete();
        $this->apiSuccess();
        return $this->apiOutput("Customer Department Deleted Successfully", 200);
    }

    /**
     * Forget Password
     */
    // public function forgetPassword(Request $request){
    //     try{
    //         $validator = Validator::make($request->all(), [
    //             "email"     => ["required", "exists:admins,email"],
    //         ],[
    //             "email.exists"  => "No Record found under this email",
    //         ]);

    //         if($validator->fails()){
    //             return $this->apiOutput($this->getValidationError($validator), 400);
    //         }
    //         $admin = CustomerDepartment::where("email", $request->email)->first();
    //         $password_reset = PasswordReset::where("tableable", $admin->getMorphClass())
    //             ->where("tableable_id", $admin->id)->where("is_used", false)
    //             ->where("expire_at", ">=", now()->format('Y-m-d H:i:s'))
    //             ->orderBy("id", "DESC")->first();
    //         if( empty($password_reset) ){
    //             $token = rand(111111, 999999);
    //             $password_reset = new PasswordReset();
    //             $password_reset->tableable      = $admin->getMorphClass();
    //             $password_reset->tableable_id   = $admin->id;
    //             $password_reset->email          = $admin->email;
    //             $password_reset->token          = $token;
    //         }
    //         $password_reset->expire_at      = now()->addHour();
    //         $password_reset->save();

    //         // Send Password Reset Email
    //         // event(new PasswordResetEvent($password_reset));

    //         $this->apiSuccess("Password Reset Code sent to your registared Email.");
    //         return $this->apiOutput();
    //     }catch(Exception $e){
    //         return $this->apiOutput($this->getError($e), 500);
    //     }
    // }

    /**
     * Password Reset
     */
    // public function passwordReset(Request $request){
    //     try{
    //         $validator = Validator::make($request->all(), [
    //             "email"     => ["required", "exists:admins,email"],
    //             "code"      => ["required", "exists:password_resets,token"],
    //             "password"  => ["required", "string"],
    //         ],[
    //             "email.exists"  => "No Record found under this email",
    //             "code.exists"   => "Invalid Verification Code",
    //         ]);
    //         if($validator->fails()){
    //             return $this->apiOutput($this->getValidationError($validator), 400);
    //         }

    //         DB::beginTransaction();
    //         $password_reset = PasswordReset::where("email", $request->email)
    //             ->where("is_used", false)
    //             ->where("expire_at", ">=", now()->format('Y-m-d H:i:s'))
    //             ->first();
    //         if( empty($password_reset) ){
    //             return $this->apiOutput($this->getValidationError($validator), 400);
    //         }
    //         $password_reset->is_used = true;
    //         $password_reset->save();

    //         $user = $password_reset->user;
    //         $user->password = bcrypt($request->password);
    //         $user->save();

    //         DB::commit();
    //         try{
    //             event(new PasswordReset($password_reset, true));
    //         }catch(Exception $e){

    //         }
    //         $this->apiSuccess("Password Reset Successfully.");
    //         return $this->apiOutput();
    //     }catch(Exception $e){
    //         return $this->apiOutput($this->getError($e), 500);
    //     }
    // }
}
