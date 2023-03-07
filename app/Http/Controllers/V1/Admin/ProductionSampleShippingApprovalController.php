<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SampleApprovalInformationResource;
use App\Models\ProductionSampleImage;
use App\Models\SampleShippingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductionSampleShippingApprovalController extends Controller
{
    public function index()
    {
       try{

            $this->data = SampleApprovalInformationResource::collection(SampleShippingApproval::all());
            $this->apiSuccess("Sample Approval Information Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request){

        try{
            $validator = Validator::make(
                $request->all(),
                 [
                    // "buyer_id"          => "required",
                    // "vendor_id"         => "required",
                    // "supplier_id"       => "required",
                    // "manufacturer_id"   => "required",
                ]

            );

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

            $shippingapproval = new SampleShippingApproval();
            $shippingapproval->po_number = $request->po_number;
            $shippingapproval->po_id = $request->po_id;
            $shippingapproval->production_sample_approval_plan = $request->production_sample_approval_plan;
            $shippingapproval->production_sample_approval_plan_buyer = $request->production_sample_approval_plan_buyer;
            $shippingapproval->production_sample_approval_actual = $request->production_sample_approval_actual;
            $shippingapproval->production_sample_dispatch_details = $request->production_sample_dispatch_details;
            $shippingapproval->production_sample_dispatch_sending_date = $request->production_sample_dispatch_sending_date;
            $shippingapproval->production_sample_dispatch_aob_number = $request->production_sample_dispatch_aob_number;
            $shippingapproval->shipment_booking_with_acs_plan = $request->shipment_booking_with_acs_plan;
            $shippingapproval->shipment_booking_with_acs_plan_buyer = $request->shipment_booking_with_acs_plan_buyer;
            $shippingapproval->shipment_booking_with_acs_actual = $request->shipment_booking_with_acs_actual;
            $shippingapproval->invoice_booking_plan = $request->invoice_booking_plan;
            $shippingapproval->invoice_booking_plan_buyer = $request->invoice_booking_plan_buyer;
            $shippingapproval->sa_approval_plan = $request->sa_approval_plan;
            $shippingapproval->sa_approval_plan_buyer = $request->sa_approval_plan_buyer;
            $shippingapproval->sa_approval_actual = $request->sa_approval_actual;
            $shippingapproval->save();
            $this->saveFileInfo($request, $shippingapproval);

            DB::commit();
            $this->apiSuccess();
            $this->data = (new SampleApprovalInformationResource($shippingapproval));
            return $this->apiOutput("Sample Approval Information Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    // Save File Info
    public function saveFileInfo($request, $shippingapproval){
        $file_path = $this->uploadFile($request, 'file', $this->pogarments_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new ProductionSampleImage();
            $data->sample_shipping_approvals_id  = $shippingapproval->id;
            $data->file_name    = $request->file_name ?? "Production_Sample_Image Upload";
            $data->file_url     = $path;
            //$data->type = $request->type;
            $data->save();
        }
    }

    public function update(Request $request){

        try{
            $validator = Validator::make(
                $request->all(),
                 [
                    // "buyer_id"          => "required",
                    // "vendor_id"         => "required",
                    // "supplier_id"       => "required",
                    // "manufacturer_id"   => "required",
                ]

            );

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

            $shippingapproval = SampleShippingApproval::find($request->id);
            $shippingapproval->po_number = $request->po_number;
            $shippingapproval->po_id = $request->po_id;
            $shippingapproval->production_sample_approval_plan = $request->production_sample_approval_plan;
            $shippingapproval->production_sample_approval_plan_buyer = $request->production_sample_approval_plan_buyer;
            $shippingapproval->production_sample_approval_actual = $request->production_sample_approval_actual;
            $shippingapproval->production_sample_dispatch_details = $request->production_sample_dispatch_details;
            $shippingapproval->production_sample_dispatch_sending_date = $request->production_sample_dispatch_sending_date;
            $shippingapproval->production_sample_dispatch_aob_number = $request->production_sample_dispatch_aob_number;
            $shippingapproval->shipment_booking_with_acs_plan = $request->shipment_booking_with_acs_plan;
            $shippingapproval->shipment_booking_with_acs_plan_buyer = $request->shipment_booking_with_acs_plan_buyer;
            $shippingapproval->shipment_booking_with_acs_actual = $request->shipment_booking_with_acs_actual;
            $shippingapproval->invoice_booking_plan = $request->invoice_booking_plan;
            $shippingapproval->invoice_booking_plan_buyer = $request->invoice_booking_plan_buyer;
            $shippingapproval->sa_approval_plan = $request->sa_approval_plan;
            $shippingapproval->sa_approval_plan_buyer = $request->sa_approval_plan_buyer;
            $shippingapproval->sa_approval_actual = $request->sa_approval_actual;
            $shippingapproval->save();
            $this->saveFileInfo($request, $shippingapproval);

            DB::commit();
            $this->apiSuccess();
            $this->data = (new SampleApprovalInformationResource($shippingapproval));
            return $this->apiOutput("Sample Approval Information Updated Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{

            $production =  SampleShippingApproval::find($request->id);
            $this->data = (new SampleApprovalInformationResource($production));
            $this->apiSuccess("Sample Approval Information Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function delete(Request $request)
    {
        SampleShippingApproval::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Sample Approval Information Deleted Successfully", 200);
    }

}
