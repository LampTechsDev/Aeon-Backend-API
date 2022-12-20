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
            $customer->logo            = $this->uploadFile($request, 'logo', $this->customer_logo, 720);
            $customer->address         = $request->address;
            $customer->email           = $request->email;
            $customer->contact_number  = $request->contact_number;
            $customer->remarks         = $request->remarks;
            $customer->status          = $request->status;
         //    $customer->created_by = $request->created_by;
         //    $customer->updated_by = $request->updated_by;
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
    ],[
        // "id"                  => "No Data Found for this Id",
        // "group_id.exists"     => "No Record found under this group",
    ]
    );

       if ($validator->fails()) {
        $this->apiOutput($this->getValidationError($validator), 400);
       }

        $customer = Customer::find($request->id);
        // if(empty($admin)){
        //     return $this->apiOutput("No Data Found", $admin);
        // }
        $customer->name            = $request->name;
        $customer->logo            = $this->uploadFile($request, 'logo', $this->customer_logo, 720);
        $customer->address         = $request->address;
        $customer->email           = $request->email;
        $customer->contact_number  = $request->contact_number;
        $customer->remarks         = $request->remarks;
        $customer->status          = $request->status;
     //    $customer->created_by = $request->created_by;
     //    $customer->updated_by = $request->updated_by;
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
//         $admin = Customer::where("email", $request->email)->first();
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
