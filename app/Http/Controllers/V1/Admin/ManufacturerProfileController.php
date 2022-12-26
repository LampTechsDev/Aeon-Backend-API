<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ManufacturerProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ManufacturerProfileResource;

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

                ],[

                ]
               );

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $manufacturer_profile = new ManufacturerProfile();

                $manufacturer_profile->vendor_id            = $request->vendor_id;
                $manufacturer_profile->factory_profile_name = $request->factory_profile_name;
                $manufacturer_profile->logo                 = $this->uploadFile($request, 'logo', $this->manufacturer_profile_logo, 720);
                $manufacturer_profile->contact_number       = $request->contact_number ;
                $manufacturer_profile->email                = $request->email;
                $manufacturer_profile->address              = $request->address ;
                $manufacturer_profile->remarks              = $request->remarks ;
                $manufacturer_profile->status               = $request->status  ;

                $manufacturer_profile->created_at           = $request->created_at;
                $manufacturer_profile->updated_at           = $request->updated_at;
                $manufacturer_profile->deleted_by           = $request->deleted_by;
                $manufacturer_profile->deleted_date         = $request->deleted_date;

                $manufacturer_profile->save();


            try{
                event(new ManufacturerProfileResource($manufacturer_profile));
            }catch(Exception $e){

            }
            DB::commit();
            $this->apiSuccess("Manufracturer Profile Added Successfully");
            $this->data = (new ManufacturerProfileResource($manufacturer_profile));
            return $this->apiOutput();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request,$id)
    {
        try{
            DB::beginTransaction();

            $validator = Validator::make($request->all(),[
                "vendor_id"                     => ["required"],
                "factory_profile_name"          => ["required"],
                "email"                         => ["required","email"],
                "status"                        => 'required',
            ],[

            ]
            );

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $manufacturer_profile = ManufacturerProfile::find($request->id);

            $manufacturer_profile->vendor_id            = $request->vendor_id;
            $manufacturer_profile->factory_profile_name = $request->factory_profile_name;
            $manufacturer_profile->logo                 = $this->uploadFile($request, 'logo', $this->manufacturer_profile_logo, 720);
            $manufacturer_profile->contact_number       = $request->contact_number ;
            $manufacturer_profile->email                = $request->email;
            $manufacturer_profile->address              = $request->address ;
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
            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function destroy(Request $request,$id)
    {
        $manufacturer_profile = ManufacturerProfile::find($request->id);
        $manufacturer_profile->delete();
        $this->apiSuccess();
        return $this->apiOutput("Manufacturer Profile Deleted Successfully", 200);
    }


}
