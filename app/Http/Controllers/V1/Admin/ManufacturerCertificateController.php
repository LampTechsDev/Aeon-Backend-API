<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManufacturerCertificateResource;
use App\Http\Resources\ManufacturerProfileResource;
use App\Models\ManufacturerCertificate;
use App\Models\VendorManufacturer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManufacturerCertificateController extends Controller
{

    public function index()
    {
        try{
            $this->data = ManufacturerCertificateResource::collection(ManufacturerCertificate::all());
            $this->apiSuccess("Manufacturer Certificate Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $certificate = ManufacturerCertificate::find($request->id);
            if( empty($certificate) ){
                return $this->apiOutput("Manufacturer Certificate Data Not Found", 400);
            }
            $this->data = (new ManufacturerCertificateResource($certificate));
            $this->apiSuccess("Manufacturer Certificate Detail Show Successfully");
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
                        "vendor_id"                 => ["required"],
                        "global_certificate_id"     => ["required"],
                        "status"                    => 'required',

                    ],[
                        // "group_id.exists"     => "No Record found under this group",
                    ]
                );

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $certificate = new ManufacturerCertificate();

                $certificate->vendor_id             = $request->vendor_id;
                $certificate->global_certificate_id = $request->global_certificate_id;
                $certificate->issue_date            = $request->issue_date;
                $certificate->validity_start_date   = $request->validity_start_date;
                $certificate->validity_end_date     = $request->validity_end_date;
                $certificate->renewal_date          = $request->renewal_date;
                $certificate->attachment            = $this->uploadFile($request, 'attachment', $this->manufacturer_certificate_attachment, 720);
                $certificate->score                 = $request->score;

                $certificate->remarks               = $request->remarks;
                $certificate->status                = $request->status;

                $certificate->created_at            = $request->created_at;
                $certificate->updated_at            = $request->updated_at;
                $certificate->deleted_by            = $request->deleted_by;
                $certificate->deleted_date          = $request->deleted_date;

                $certificate->save();

            try{
                event(new ManufacturerCertificateResource($certificate));
            }catch(Exception $e){


            }
            DB::commit();
            $this->apiSuccess("Manufacturer Certificate Added Successfully");
            $this->data = (new ManufacturerCertificateResource($certificate));
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
            "vendor_id"                 => ["required"],
            "global_certificate_id"     => ["required"],
            "status"                    => 'required',
        ]);


           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            DB::beginTransaction();
            $certificate = ManufacturerCertificate::find($request->id);

            $certificate->vendor_id             = $request->vendor_id;
            $certificate->global_certificate_id = $request->global_certificate_id;
            $certificate->issue_date            = $request->issue_date;
            $certificate->validity_start_date   = $request->validity_start_date;
            $certificate->validity_end_date     = $request->validity_end_date;
            $certificate->renewal_date          = $request->renewal_date;
            $certificate->attachment            = $this->uploadFile($request, 'attachment', $this->manufacturer_certificate_attachment, 720);
            $certificate->score                 = $request->score;

            $certificate->remarks               = $request->remarks;
            $certificate->status                = $request->status;
            $certificate->created_at            = $request->created_at;
            $certificate->updated_at            = $request->updated_at;
            $certificate->deleted_by            = $request->deleted_by;
            $certificate->deleted_date          = $request->deleted_date;

            $certificate->save();
            DB::commit();
            $this->apiSuccess();

            $this->data = (new ManufacturerCertificateResource($certificate));
            return $this->apiOutput("Manufacturer Certificate Updated Successfully");

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
        ManufacturerCertificate::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Manufacturer Certificate Details Deleted Successfully", 200);
    }


}
