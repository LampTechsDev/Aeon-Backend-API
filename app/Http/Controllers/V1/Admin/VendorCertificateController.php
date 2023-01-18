<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\PoPictureGarments;
use App\Models\VendorCertificate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VendorCertificateResource;

class VendorCertificateController extends Controller
{

    public function index()
    {
        try{
            $this->data = VendorCertificateResource::collection(VendorCertificate::all());
            $this->apiSuccess(" Vendor Certificate Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $certificate = VendorCertificate::find($request->id);
            if( empty($certificate) ){
                return $this->apiOutput("Customer Department Data Not Found", 400);
            }
            $this->data = (new VendorCertificateResource ($certificate));
            $this->apiSuccess("Vendor certificate Detail Show Successfully");
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
                    "vendor_id"                 => ["required"],
                    "global_certificate_id"     => ["required"],
                    "status"                    => 'required',
                ]);

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                DB::beginTransaction();
                $certificate = new VendorCertificate();

                $certificate->vendor_id             = $request->vendor_id;
                $certificate->global_certificate_id = $request->global_certificate_id;
                $certificate->certificate_name      = $request->certificate_name;
                $certificate->certificate_logo      = $this->uploadFileNid($request, 'certificate_logo', $this->vendor_certificate_logo, 720);
                $certificate->issue_date            = $request->issue_date;
                $certificate->validity_start_date   = $request->validity_start_date;
                $certificate->validity_end_date     = $request->validity_end_date;
                $certificate->renewal_date          = $request->renewal_date;
                $certificate->attachment            = $this->uploadFileNid($request, 'attachment', $this->vendor_certificate_attachment, 720);
                $certificate->score                 = $request->score;

                $certificate->remarks               = $request->remarks;
                $certificate->status                = $request->status;

                $certificate->created_at            = $request->created_at;
                $certificate->updated_at            = $request->updated_at;
                $certificate->deleted_by            = $request->deleted_by;
                $certificate->deleted_date          = $request->deleted_date;

                $certificate->save();
                // $this->saveFileInfo($request, $certificate);
                DB::commit();

            try{
                event(new VendorCertificateResource($certificate));
            }catch(Exception $e){


            }

            $this->apiSuccess("Vendor Certificate Added Successfully");
            $this->data = (new VendorCertificateResource($certificate));
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
        ] );

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            DB::beginTransaction();
            $certificate = VendorCertificate::find($request->id);

            $certificate->vendor_id             = $request->vendor_id;
            $certificate->global_certificate_id = $request->global_certificate_id;
            $certificate->certificate_name      = $request->certificate_name;
            $certificate->certificate_logo      = $this->uploadFileNid($request, 'certificate_logo', $this->vendor_certificate_logo, 720);
            $certificate->issue_date            = $request->issue_date;
            $certificate->validity_start_date   = $request->validity_start_date;
            $certificate->validity_end_date     = $request->validity_end_date;
            $certificate->renewal_date          = $request->renewal_date;
            $certificate->attachment            = $this->uploadFileNid($request, 'attachment', $this->vendor_certificate_attachment, 720);
            $certificate->score                 = $request->score;

            $certificate->remarks               = $request->remarks;
            $certificate->status                = $request->status;

            $certificate->created_at            = $request->created_at;
            $certificate->updated_at            = $request->updated_at;
            $certificate->deleted_by            = $request->deleted_by;
            $certificate->deleted_date          = $request->deleted_date;

            $certificate->save();
            DB::commit();

            $this->apiSuccess("Vendor Certificate Updated Successfully");
            $this->data = (new VendorCertificateResource($certificate));
            return $this->apiOutput();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    /*
       Save File Info
    */
        // public function saveFileInfo($request, $certificate){
        //     $file_path = $this->uploadFile($request, 'file', $this->vendor_certificate_attachment, 720);

        //     if( !is_array($file_path) ){
        //         $file_path = (array) $file_path;
        //     }
        //     foreach($file_path as $path){
        //         $data = new PoPictureGarments();
        //         $data->po_id = $certificate->id;
        //         $data->file_name    = $request->file_name ?? "PO_Picture_Garments Upload";
        //         $data->file_url     = $path;
        //         $data->type = $request->type;
        //         $data->save();
        //     }
        // }

    /*
       Delete
    */
    public function delete(Request $request)
    {
        VendorCertificate::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Vendor Certificate Deleted Successfully", 200);
    }


}
