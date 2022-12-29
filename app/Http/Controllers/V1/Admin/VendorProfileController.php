<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\VendorProfile;
use Illuminate\Support\Facades\DB;
use App\Events\AccountRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VendorProfileResource;
use App\Models\VendorProfileAttachFileUpload;

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
                DB::beginTransaction();
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
                $this->saveFileInfo($request, $vendor_profile);
                DB::commit();

                $this->apiSuccess("Vendor Profile Added Successfully");
                $this->data = (new VendorProfileResource($vendor_profile));
                return $this->apiOutput();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    // Save File Info
    public function saveFileInfo($request, $vendor_profile){
        $file_path = $this->uploadFile($request, 'file', $this->vendor_profile_attach_file_upload, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new VendorProfileAttachFileUpload();
            $data->vendor_profile_id = $vendor_profile->id;
            $data->file_name         = $request->file_name ?? "Vendor File Upload";
            $data->file_url          = $path;
            $data->save();

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

    public function updateAttachFile(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                "id"            => ["required"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data =VendorProfileAttachFileUpload::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFile($request, 'picture', $this->vendor_profile_attach_file_upload, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("Vendor Attact File Updated Successfully");
            return $this->apiOutput();


        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }



    public function deleteAttachFile(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                "id"            => ["required"],
            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }


            $vendorattachupload=VendorProfileAttachFileUpload::where('id',$request->id);
            $vendorattachupload->delete();
            $this->apiSuccess("Vendor Profile Attach File Deleted Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    // public function addFileTicket(Request $request){
    //     try{
    //         $validator = Validator::make( $request->all(),[
    //             "ticket_id"            => ["required"],

    //         ]);

    //         if ($validator->fails()) {
    //             return $this->apiOutput($this->getValidationError($validator), 200);
    //         }

    //         $this->saveAddFileInfo($request);
    //         $this->apiSuccess("Ticket File Added Successfully");
    //         return $this->apiOutput();


    //     }catch(Exception $e){
    //         return $this->apiOutput($this->getError( $e), 500);
    //     }
    // }

}
