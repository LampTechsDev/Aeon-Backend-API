<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\VendorProfile;
use App\Events\AccountRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VendorProfileResource;

class VendorProfileController extends Controller
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

    /**
     * Login
     */
    // public function login(Request $request){

    //     $admin=Admin::all();
    //     try{
    //         $validator = Validator::make($request->all(), [
    //             "email"     => ["required", "email", "exists:admins,email"],
    //             "password"  => ["required", "string", "min:4", "max:40"]
    //         ]);
    //         if($validator->fails()){
    //             return $this->apiOutput($this->getValidationError($validator), 400);
    //         }
    //         $admin =Admin::where("email", $request->email)->first();
    //         if( !Hash::check($request->password, $admin->password) ){
    //             return $this->apiOutput("Sorry! Password Dosen't Match", 401);
    //         }
    //         if( !$admin->status ){
    //             return $this->apiOutput("Sorry! your account is temporaly blocked", 401);
    //         }

    //         // Issueing Access Token
    //         $this->access_token = $admin->createToken($request->ip() ?? "admin_access_token")->plainTextToken;

    //         Session::put('access_token',$this->access_token);
    //         // echo Session::get('access_token');
    //         $this->apiSuccess("Login Successfully");
    //         // Flash Admin Group Permission
    //         //Session::forget("group_access");

    //         $this->data = (new AdminResource($admin));
    //         return $this->apiOutput();

    //     }catch(Exception $e){
    //         return $this->apiOutput($this->getError($e), 500);
    //     }
    // }
    // public function logout(Request $request){
    //     $user = $request->user();
    //     $user->tokens()->delete();
    //     $this->apiSuccess("Logout Successfull");
    //     return $this->apiOutput();
    // }

    public function index()
    {
        try{
            $this->data = VendorProfileResource::collection(VendorProfile::all());
            $this->apiSuccess("Vendor Profile Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $vendor_profile = VendorProfile::find($request->id);
            if( empty($vendor_profile) ){
                return $this->apiOutput("Vendor Profile Data Not Found", 400);
            }
            $this->data = (new VendorProfileResource ($vendor_profile));
            $this->apiSuccess("Vendor Profile Detail Show Successfully");
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
                    "vendor_id"                     => ["required"],
                    "factory_profile_name"          => ["required"],
                    "email"                         => ["required","email"],
                    "status"                        => 'required',

                ],[

                ]
               );

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $vendor_profile = new VendorProfile();

                $vendor_profile->vendor_id            = $request->vendor_id;
                $vendor_profile->factory_profile_name = $request->factory_profile_name;
                $vendor_profile->logo                 = $this->uploadFile($request, 'logo', $this->vendor_profile_logo, 720);
                $vendor_profile->contact_number       = $request->contact_number ;
                $vendor_profile->email                = $request->email;
                $vendor_profile->address              = $request->address ;
                $vendor_profile->remarks              = $request->remarks ;
                $vendor_profile->status               = $request->status  ;

                $vendor_profile->created_at           = $request->created_at;
                $vendor_profile->updated_at           = $request->updated_at;
                $vendor_profile->deleted_by           = $request->deleted_by;
                $vendor_profile->deleted_date         = $request->deleted_date;

                $vendor_profile->save();


            try{
                event(new AccountRegistration($vendor_profile));
            }catch(Exception $e){

            }
            $this->apiSuccess("Vendor Profile Added Successfully");
            $this->data = (new VendorProfileResource($vendor_profile));
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request,$id)
    {
        try{
        $validator = Validator::make($request->all(),[
            "vendor_id"                     => ["required"],
            "factory_profile_name"          => ["required"],
            "email"                         => ["required","email"],
            "status"                        => 'required',
        ],[
            // "id"                  => "No Data Found for this Id",
            // "group_id.exists"     => "No Record found under this group",
        ]
        );

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $vendor_profile = VendorProfile::find($request->id);
            // if(empty($admin)){
            //     return $this->apiOutput("No Data Found", $admin);
            // }
            $vendor_profile->vendor_id            = $request->vendor_id;
            $vendor_profile->factory_profile_name = $request->factory_profile_name;
            $vendor_profile->logo                 = $this->uploadFile($request, 'logo', $this->vendor_profile_logo, 720);
            $vendor_profile->contact_number       = $request->contact_number ;
            $vendor_profile->email                = $request->email;
            $vendor_profile->address              = $request->address ;
            $vendor_profile->remarks              = $request->remarks ;
            $vendor_profile->status               = $request->status  ;

            $vendor_profile->created_at           = $request->created_at;
            $vendor_profile->updated_at           = $request->updated_at;
            $vendor_profile->deleted_by           = $request->deleted_by;
            $vendor_profile->deleted_date         = $request->deleted_date;;

            $vendor_profile->save();
            $this->apiSuccess("Vendor Profile Updated Successfully");
            $this->data = (new VendorProfileResource($vendor_profile));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function destroy(Request $request,$id)
    {
        $vendor_profile = VendorProfile::find($request->id);
        $vendor_profile->delete();
        $this->apiSuccess();
        return $this->apiOutput("Vendor Profile Deleted Successfully", 200);
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
    //         $admin = Vendor::where("email", $request->email)->first();
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
