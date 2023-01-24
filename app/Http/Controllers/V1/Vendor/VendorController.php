<?php

namespace App\Http\Controllers\V1\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
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
        return $this->apiOutput();
    }

    /**
     * Login
     */
    public function login(Request $request){
        $vendor=Vendor::all();
        try{
            $validator = Validator::make($request->all(), [
                "email"     => ["required", "email", "exists:vendors,email"],
                "password"  => ["required", "string", "min:4", "max:40"]
            ]); 
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator), 400);
            }
            $vendor = Vendor::where("email", $request->email)->first();
            if( !Hash::check($request->password, $vendor->password) ){
                return $this->apiOutput("Sorry! Password Dosen't Match", 401);
            }
            // if( !$patient->status ){
            //     return $this->apiOutput("Sorry! your account is temporaly blocked", 401);
            // }
            // Issueing Access Token
             //$this->access_token = $admin->createToken($request->ip() ?? "admin_access_token")->plainTextToken;
           
            // $this->access_token = $patient->createToken($request->ip() ?? "patient_access_token")->plainTextToken;
            // Session::put('access_token',$this->access_token);
            $this->access_token = $vendor->createToken($request->ip() ?? "vendor_access_token")->plainTextToken;
            Session::put('access_token',$this->access_token);
            $this->apiSuccess("Login Successfully");
            $this->data = (new VendorResource($vendor));
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }
}
