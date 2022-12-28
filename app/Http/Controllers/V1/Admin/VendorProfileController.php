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
                $vendor_profile->business_segments    = $request->business_segments ;
                $vendor_profile->manufacturing_unit   = $request->manufacturing_unit ;
                $vendor_profile->buying_partners      = $request->buying_partners ;
                $vendor_profile->social_platform_link = $request->social_platform_link ;
                $vendor_profile->video_link           = $request->video_link ;
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

    public function update(Request $request)
    {
        try{
        $validator = Validator::make($request->all(),[
            "vendor_id"                     => ["required"],
            "factory_profile_name"          => ["required"],
            "email"                         => ["required","email"],
            "status"                        => 'required',
        ]);

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $vendor_profile = VendorProfile::find($request->id);

            $vendor_profile->vendor_id            = $request->vendor_id;
            $vendor_profile->factory_profile_name = $request->factory_profile_name;
            $vendor_profile->logo                 = $this->uploadFile($request, 'logo', $this->vendor_profile_logo, 720);
            $vendor_profile->contact_number       = $request->contact_number ;
            $vendor_profile->email                = $request->email;
            $vendor_profile->address              = $request->address ;
            $vendor_profile->business_segments    = $request->business_segments ;
            $vendor_profile->manufacturing_unit   = $request->manufacturing_unit ;
            $vendor_profile->buying_partners      = $request->buying_partners ;
            $vendor_profile->social_platform_link = $request->social_platform_link ;
            $vendor_profile->video_link           = $request->video_link ;
            $vendor_profile->remarks              = $request->remarks ;
            $vendor_profile->status               = $request->status  ;

            $vendor_profile->created_at           = $request->created_at;
            $vendor_profile->updated_at           = $request->updated_at;
            $vendor_profile->deleted_by           = $request->deleted_by;
            $vendor_profile->deleted_date         = $request->deleted_date;

            $vendor_profile->save();
            $this->apiSuccess("Vendor Profile Updated Successfully");
            $this->data = (new VendorProfileResource($vendor_profile));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    /*
       Delete
    */
    public function delete(Request $request)
    {
        VendorProfile::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Vendor Profile Deleted Successfully", 200);
    }

}
