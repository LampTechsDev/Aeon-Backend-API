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
    public function index(){
        try{

        $this->data = VendorResource::collection(Vendor::all());
        $this->apiSuccess("Vendor List Loaded Successfully");
        return $this->apiOutput();

    }catch(Exception $e){
        return $this->apiOutput($this->getError($e), 500);
    }
    }
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

    public function store(Request $request){
        try{
            $validator = Validator::make( $request->all(),[

                "name"          => ["required", "min:4"],
                "email"         => ["required","email"],
                "status"        => 'required',
            ]);

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }

            $vendor = new Vendor();

            $vendor->name           = $request->name;
            $vendor->logo           = $this->uploadFileNid($request, 'logo', $this->vendor_logo, 720);
            $vendor->address        = $request->address;
            $vendor->email          = $request->email;
            $vendor->password = !empty($request->password) ? bcrypt($request->password) : $vendor->password;
            $vendor->contact_number = $request->contact_number;
            $vendor->remarks        = $request->remarks;
            $vendor->status         = $request->status;
            // $vendor->created_at     = $request->created_at;
            // $vendor->updated_at     = $request->updated_at;
            // $vendor->deleted_by     = $request->deleted_by;
            // $vendor->deleted_date   = $request->deleted_date;

            $vendor->save();
            $this->apiSuccess();
            $this->data = (new VendorResource($vendor));
            return $this->apiOutput("Vendor Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function update(Request $request){
        try{
            $validator = Validator::make( $request->all(),[

                "id"            => ["required"],
                "name"          => ["required", "min:4"],
                "email"         => ["required","email"],
                "status"        => 'required',
            ]);

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }

            $vendor = Vendor::find($request->id);
            $vendor->name = $request->name;
            $vendor->logo = $this->uploadFileNid($request, 'logo', $this->vendor_logo, 720);
            $vendor->address = $request->address;
            $vendor->email = $request->email;
            $vendor->password = !empty($request->password) ? bcrypt($request->password) : $vendor->password;
            $vendor->contact_number = $request->contact_number;
            $vendor->remarks = $request->remarks;
            $vendor->status = $request->status;
            // $vendor->created_at = $request->created_at;
            // $vendor->updated_at = $request->updated_at;
            // $vendor->deleted_by = $request->deleted_by;
            // $vendor->deleted_date = $request->deleted_date;

            $vendor->save();
            $this->apiSuccess();
            $this->data = (new VendorResource($vendor));
            return $this->apiOutput("Vendor Updated Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

     /*
    Show
    */
    public function show(Request $request)
    {
        try{

            $vendor = Vendor::find($request->id);
            $this->data = (new VendorResource($vendor));
            $this->apiSuccess("Vendor Details Showed Successfully");
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
        Vendor::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Vendor Details Deleted Successfully", 200);
    }
}
