<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ManufacturerProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ManufacturerProfileResource;
use App\Models\ManufacturerProfileAttachFileUpload;

class ManufacturerProfileController extends Controller
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
            $this->data = ManufacturerProfileResource::collection(ManufacturerProfile::all());
            $this->apiSuccess("Manufacturer Profile Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $manufacturer_profile = ManufacturerProfile::find($request->id);
            if( empty($manufacturer_profile) ){
                return $this->apiOutput("Manufacturer Profile Data Not Found", 400);
            }
            $this->data = (new ManufacturerProfileResource ($manufacturer_profile));
            $this->apiSuccess("Manufacturer Profile Detail Show Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request)
    {

        try{
            DB::beginTransaction();
            $validator = Validator::make(
                $request->all(),
                [
                    "vendor_id"                     => ["required"],
                    "factory_profile_name"          => ["required"],
                    "email"                         => ["required","email"],
                    "status"                        => 'required',
                ]);

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $manufacturer_profile = new ManufacturerProfile();

                $manufacturer_profile->vendor_id            = $request->vendor_id;
                $manufacturer_profile->factory_profile_name = $request->factory_profile_name;
                $manufacturer_profile->vendor_manufacturer_id = $request->vendor_manufacturer_id;
                $manufacturer_profile->logo                 = $this->uploadFileNid($request, 'logo', $this->manufacturer_profile_logo, 720);
                $manufacturer_profile->contact_number       = $request->contact_number ;
                $manufacturer_profile->email                = $request->email;
                $manufacturer_profile->address              = $request->address ;
                $manufacturer_profile->business_segments    = $request->business_segments ;
                $manufacturer_profile->buying_partners      = $request->buying_partners ;
                $manufacturer_profile->social_platform_link = $request->social_platform_link ;
                $manufacturer_profile->video_link           = $request->video_link ;
                $manufacturer_profile->remarks              = $request->remarks ;
                $manufacturer_profile->status               = $request->status  ;

                $manufacturer_profile->created_at           = $request->created_at;
                $manufacturer_profile->updated_at           = $request->updated_at;
                $manufacturer_profile->deleted_by           = $request->deleted_by;
                $manufacturer_profile->deleted_date         = $request->deleted_date;

                $manufacturer_profile->save();
                $this->saveFileInfo($request, $manufacturer_profile);

            DB::commit();
            $this->apiSuccess("Manufracturer Profile Added Successfully");
            $this->data = (new ManufacturerProfileResource($manufacturer_profile));
            return $this->apiOutput();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

        // Save File Info
        public function saveFileInfo($request, $manufacturer_profile){
            $file_path = $this->uploadFile($request, 'file', $this->manufacturer_profile_attach_file_upload, 720);

            if( !is_array($file_path) ){
                $file_path = (array) $file_path;
            }
            foreach($file_path as $path){
                $data = new ManufacturerProfileAttachFileUpload();
                $data->manufactur_p_id   = $manufacturer_profile->id;
                $data->file_name         = $request->file_name ?? "Manufacturer File Upload";
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
            $manufacturer_profile = ManufacturerProfile::find($request->id);

            $manufacturer_profile->vendor_id            = $request->vendor_id;
            $manufacturer_profile->factory_profile_name = $request->factory_profile_name;
            $manufacturer_profile->vendor_manufacturer_id = $request->vendor_manufacturer_id;
            $manufacturer_profile->logo                 = $this->uploadFileNid($request, 'logo', $this->manufacturer_profile_logo, 720);
            $manufacturer_profile->contact_number       = $request->contact_number ;
            $manufacturer_profile->email                = $request->email;
            $manufacturer_profile->address              = $request->address ;
            $manufacturer_profile->business_segments    = $request->business_segments ;
            $manufacturer_profile->buying_partners      = $request->buying_partners ;
            $manufacturer_profile->social_platform_link = $request->social_platform_link ;
            $manufacturer_profile->video_link           = $request->video_link ;
            $manufacturer_profile->remarks              = $request->remarks ;
            $manufacturer_profile->status               = $request->status  ;

            $manufacturer_profile->created_at           = $request->created_at;
            $manufacturer_profile->updated_at           = $request->updated_at;
            $manufacturer_profile->deleted_by           = $request->deleted_by;
            $manufacturer_profile->deleted_date         = $request->deleted_date;

            $manufacturer_profile->save();
            $this->apiSuccess("Manufacturer Profile Updated Successfully");
            $this->data = (new ManufacturerProfileResource($manufacturer_profile));
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
        ManufacturerProfile::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Manufacturer Profile Deleted Successfully", 200);
    }

    public function updateAttachFile(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                "id"            => ["required"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data =ManufacturerProfileAttachFileUpload::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFile($request, 'picture', $this->manufacturer_profile_attach_file_upload, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("Manufacturer Attact File Updated Successfully");
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


            $manufacturerattachupload=ManufacturerProfileAttachFileUpload::where('id',$request->id);
            $manufacturerattachupload->delete();
            $this->apiSuccess("Manufacturer Profile Attach File Deleted Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


}
