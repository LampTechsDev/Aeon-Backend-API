<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
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
                $certificate = new VendorCertificate();

                $certificate->vendor_id             = $request->vendor_id;
                $certificate->global_certificate_id = $request->global_certificate_id;
                $certificate->issue_date            = $request->issue_date;
                $certificate->validity_start_date   = $request->validity_start_date;
                $certificate->validity_end_date     = $request->validity_end_date;
                $certificate->renewal_date          = $request->renewal_date;
                $certificate->attachment            = $request->attachment;
                $certificate->score                 = $request->score;

                $certificate->remarks               = $request->remarks;
                $certificate->status                = $request->status;
             //    $customer->created_by = $request->created_by;
             //    $customer->updated_by = $request->updated_by;
                $certificate->created_at            = $request->created_at;
                $certificate->updated_at            = $request->updated_at;
                $certificate->deleted_by            = $request->deleted_by;
                $certificate->deleted_date          = $request->deleted_date;

                $certificate->save();

            try{
                event(new VendorCertificateResource($certificate));
            }catch(Exception $e){


            }
            DB::commit();
            $this->apiSuccess("Certificate Added Successfully");
            $this->data = (new VendorCertificateResource($certificate));
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
            "vendor_id"                 => ["required"],
            "global_certificate_id"     => ["required"],
            "status"                    => 'required',
        ],[
            // "id"                  => "No Data Found for this Id",
            // "group_id.exists"     => "No Record found under this group",
        ]
        );

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $certificate = VendorCertificate::find($request->id);
            // if(empty($admin)){
            //     return $this->apiOutput("No Data Found", $admin);
            // }

            $certificate->vendor_id             = $request->vendor_id;
            $certificate->global_certificate_id = $request->global_certificate_id;
            $certificate->issue_date            = $request->issue_date;
            $certificate->validity_start_date   = $request->validity_start_date;
            $certificate->validity_end_date     = $request->validity_end_date;
            $certificate->renewal_date          = $request->renewal_date;
            $certificate->attachment            = $request->attachment;
            $certificate->score                 = $request->score;

            $certificate->remarks               = $request->remarks;
            $certificate->status                = $request->status;
         //    $customer->created_by = $request->created_by;
         //    $customer->updated_by = $request->updated_by;
            $certificate->created_at            = $request->created_at;
            $certificate->updated_at            = $request->updated_at;
            $certificate->deleted_by            = $request->deleted_by;
            $certificate->deleted_date          = $request->deleted_date;

            $certificate->save();

            $this->apiSuccess("Vendor Certificate Updated Successfully");

            $this->data = (new VendorCertificateResource($certificate));
            return $this->apiOutput();
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function destroy(Request $request,$id)
    {
        $certificate = VendorCertificate::find($request->id);
        $certificate->delete();
        $this->apiSuccess();
        return $this->apiOutput("Certificate Deleted Successfully", 200);
    }


}
