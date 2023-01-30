<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CriticalPathResource;
use App\Http\Resources\ManualPoResource;
use App\Models\BulkFabricInformation;
use App\Models\CriticalPath;
use App\Models\CriticalPathMasterFile;
use App\Models\ExFactory;
use App\Models\InspectionInformation;
use App\Models\LabDipsEmbellishmentInformation;
use App\Models\ManualPo;
use App\Models\ManualPoDeliveryDetails;
use App\Models\ManualPoItemDetails;
use App\Models\Payment;
use App\Models\PoArtwork;
use App\Models\PoPictureGarments;
use App\Models\PpMeeting;
use App\Models\ProductionInformation;
use App\Models\SampleApprovalInformation;
use App\Models\SampleShippingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class ManualPoController extends Controller
{


    public function index(){
        try{

                $this->data = ManualPoResource::collection(ManualPo::all());
                $this->apiSuccess("Manual Po Loaded Successfully");
                return $this->apiOutput();

            }catch(Exception $e){
                return $this->apiOutput($this->getError($e), 500);
            }
    }

     /*
    Store
    */

    public function store(Request $request){

        try{
            $validator = Validator::make( 
                $request->all(),
                 [
                    "buyer_id"          => "required",
                    "vendor_id"         => "required",
                    "supplier_id"       => "required",
                    "manufacturer_id"   => "required",
                ]
                
            );

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

            $manualpo = new ManualPo();
            $manualpo->buyer_id = $request->buyer_id;
            $manualpo->vendor_id = $request->vendor_id;
            $manualpo->supplier_id = $request->supplier_id;
            $manualpo->manufacturer_id = $request->manufacturer_id;
            $manualpo->customer_department_id = $request->customer_department_id;
            $manualpo->	note = $request->note;
            $manualpo->terms_conditions = $request->terms_conditions;
            $manualpo->first_delivery_date = $request->first_delivery_date;
            $manualpo->second_shipment_date = $request->second_shipment_date;
            $manualpo->vendor_po_date = $request->vendor_po_date;
            $manualpo->current_buyer_po_price = $request->current_buyer_po_price;
            $manualpo->vendor_po_price = $request->vendor_po_price;
            $manualpo->accessorize_price = $request->accessorize_price;
            $manualpo->plm_no = $request->plm_no;
            $manualpo->description = $request->description;
            $manualpo->fabric_quality = $request->fabric_quality;
            $manualpo->fabric_content = $request->fabric_content;
            $manualpo->currency=$request->currency;
            $manualpo->payment_method=$request->payment_method;
            $manualpo->payment_terms=$request->payment_terms;
            $manualpo->fabric_weight=$request->fabric_weight;
            $manualpo->po_no=$request->po_no;
            $manualpo->season_id=$request->season_id;
            $manualpo->save();
            $this->saveFileInfo($request, $manualpo);
            $this->saveExtraFileInfo($request, $manualpo);
            $this->deliveryDetails($request,$manualpo);
            $this->saveCriticalPath($request,$manualpo);

            DB::commit();
            $this->apiSuccess();
            $this->data = (new ManualPoResource($manualpo));
            return $this->apiOutput("Manual Po Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    // Save File Info
    public function saveFileInfo($request, $manualpo){
        $file_path = $this->uploadFile($request, 'file', $this->pogarments_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PoPictureGarments();
            $data->po_id = $manualpo->id;
            $data->file_name    = $request->file_name ?? "PO_Picture_Garments Upload";
            $data->file_url     = $path;
            $data->type = $request->type;
            $data->save();
        }
    }


    // Save Extra File Info
    public function saveExtraFileInfo($request, $manualpo){
        $file_path = $this->uploadFile($request, 'poArtwork', $this->poartworks_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PoArtwork();
            $data->po_id = $manualpo->id;
            $data->file_name    = $request->file_name ?? "PO_Art_Works Upload";
            $data->file_url     = $path;
            $data->type = $request->typeArtwork;
            $data->save();

        }
    }


    public function deliveryDetails($request, $manualpo){

            $data = new ManualPoDeliveryDetails();
            $data->po_id = $manualpo->id;
            $data->ship_method = $request->ship_method;
            $data->inco_terms = $request->inco_terms;
            $data->landing_port = $request->landing_port;
            $data->discharge_port = $request->discharge_port;
            $data->country_of_origin = $request->country_of_origin;
            $data->ex_factor_date = $request->ex_factor_date;
            $data->care_label_date = $request->care_label_date;
            $data->save();
    }

    public function saveCriticalPath($request,$manualpo){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            
            DB::beginTransaction();
            $criticalPath = new CriticalPath();
            $criticalPath->po_id = $manualpo->id;
            $lab_dips_embellishment_id = $this->saveLabDipsEmbellishmentInfo($request, $manualpo);
            $labdibs = new LabDipsEmbellishmentInformation();
            
            $this->savebulkFabricInformationInfo($request, $manualpo);
            $this->saveSampleApprovalInformation($request, $manualpo);
            $this->savePpMeetingInformation($request, $manualpo);
            $this->saveProductionInformation($request, $manualpo);
            $this-> saveInspectionInformation($request,$manualpo);
            $this->saveSampleShippingApproval($request,$manualpo);
            $this->saveExFactoryVesselInfo($request,$manualpo);
            $this->savePaymentInfo($request,$manualpo);
            
            $criticalPath->inspection_information_id=$request->inspection_information_id;
            $criticalPath->labdips_embellishment_id=  $labdibs->id;
            $criticalPath->bulk_fabric_information_id =$request->bulk_fabric_information_id;
            $criticalPath->fabric_mill_id = $request->fabric_mill_id;
            $criticalPath->sample_approval_id=$request->sample_approval_id;
            $criticalPath->pp_meeting_id=$request->pp_meeting_id;
            $criticalPath->production_information_id=$request->production_information_id;
            $criticalPath->production_information_id=$request->production_information_id;
            $criticalPath->sample_shipping_approvals_id=$request->sample_shipping_approvals_id;
            $criticalPath->ex_factories_id=$request->ex_factories_id;
            $criticalPath->payments_id=$request->payments_id;
            $criticalPath->	lead_times=$request->lead_times;
            $criticalPath->lead_type=$request->lead_type;
            $criticalPath->	official_po_plan=$request->official_po_plan;
            $criticalPath->official_po_actual=$request->official_po_actual;
            $criticalPath->status=$request->status;
            $criticalPath->aeon_comments=$request->aeon_comments;
            $criticalPath->vendor_comments=$request->vendor_comments;
            $criticalPath->other_comments=$request->other_comments;
            $criticalPath->save();

            $this->saveCriticalPathFileInfo($request, $criticalPath);
            DB::commit();
            $this->apiSuccess();
            $this->data = (new CriticalPathResource($criticalPath));
            return $this->apiOutput("Critical Path Department Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

          
          /**
           * LabDipsEmbellishment Department
           * @return int
           */

            public function saveLabDipsEmbellishmentInfo($request, $manualpo){

            
                    //DB::beginTransaction();
                    try{
                        $validator = Validator::make( $request->all(),[
                            // 'name'          => ["required", "min:4"],
                            // 'description'   => ["nullable", "min:4"],
                        ]);
                            
                        if ($validator->fails()) {    
                            $this->apiOutput($this->getValidationError($validator), 400);
                        }

                    }catch(Exception $e){
                        return $this->apiOutput($this->getError( $e), 500);
                    }
                    $labDips = new LabDipsEmbellishmentInformation();
                    $labDips->po_number = $request->po_number ;
                    $labDips->po_id = $request->po_id;
                    $labDips->colour_std_print_artwork_sent_to_supplier_plan = $request->first_delivery_date;
                    $labDips->colour_std_print_artwork_sent_to_supplier_actual = $request->colour_std_print_artwork_sent_to_supplier_actual;
                    $labDips->lab_dip_approval_plan = $request->lab_dip_approval_plan;
                    $labDips->lab_dip_approval_actual = $request->lab_dip_approval_actual;
                    //$labDips->lab_dip_dispatch_details = $request->lab_dip_dispatch_details;
                    $labDips->lab_dip_dispatch_sending_date = $request->lab_dip_dispatch_sending_date;
                    //$labDips->lab_dip_dispatch_aob_number = $request->lab_dip_dispatch_aob_number;
                    $labDips->embellishment_so_approval_plan = $request->embellishment_so_approval_plan;
                    $labDips->embellishment_so_approval_actual = $request->embellishment_so_approval_actual;
                    //$labDips->embellishment_so_dispatch_details = $request->embellishment_so_dispatch_details;
                    $labDips->embellishment_so_dispatch_sending_date = $request->embellishment_so_dispatch_sending_date;
                    //$labDips->embellishment_so_dispatch_aob_number = $request->embellishment_so_dispatch_aob_number;
                    $labDips->save();
                    
                    return $labDips->id;

                  
                    //DB::commit();
                
                
        }

        //Bulk Fabric Information
        public function savebulkFabricInformationInfo($request, $manualpo){

               // DB::beginTransaction();
            
                $bulkFabricInformation = new BulkFabricInformation();
                $bulkFabricInformation->po_number = $request->po_number ;
                $bulkFabricInformation->po_id = $request->po_id;
                $bulkFabricInformation->fabric_ordered_plan = $request->fabric_ordered_plan;
                $bulkFabricInformation->fabric_ordered_actual = $request->fabric_ordered_actual;
                $bulkFabricInformation->bulk_fabric_knit_down_approval_plan = $request->bulk_fabric_knit_down_approval_plan;
                $bulkFabricInformation->bulk_fabric_knit_down_approval_actual = $request->bulk_fabric_knit_down_approval_actual;
                //$bulkFabricInformation->bulk_fabric_knit_down_dispatch_details = $request->bulk_fabric_knit_down_dispatch_details;
                //$bulkFabricInformation->bulk_fabric_knit_down_dispatch_sending_date = $request->bulk_fabric_knit_down_dispatch_sending_date;
                //$bulkFabricInformation->bulk_fabric_knit_down_dispatch_aob_number = $request->bulk_fabric_knit_down_dispatch_aob_number;
                $bulkFabricInformation->bulk_yarn_fabric_inhouse_plan = $request->bulk_yarn_fabric_inhouse_plan;
                $bulkFabricInformation->bulk_yarn_fabric_inhouse_actual = $request->bulk_yarn_fabric_inhouse_actual;

                $bulkFabricInformation->save();
                $bulkFabricInformation->id;
                //$this->saveFileInfo($request, $bulkFabricInformation );
                
                //DB::commit();
        }

        //Sample Approval Information

        public function saveSampleApprovalInformation($request, $manualpo){
            //DB::beginTransaction();

            $sampleApproval = new SampleApprovalInformation();
            $sampleApproval->po_id=$request->po_id;
            $sampleApproval->po_number=$request->po_number;
            $sampleApproval->development_photo_sample_sent_plan = $request->development_photo_sample_sent_plan;
            $sampleApproval->development_photo_sample_sent_actual = $request->development_photo_sample_sent_actual;
            $sampleApproval->development_photo_sample_dispatch_details = $request->development_photo_sample_dispatch_details;
            $sampleApproval->fit_approval_plan = $request->fit_approval_plan;
            $sampleApproval->fit_approval_actual = $request->fit_approval_actual;
            //$sampleApproval->fit_sample_dispatch_details = $request->fit_sample_dispatch_details;
            //$sampleApproval->fit_sample_dispatch_sending_date = $request->fit_sample_dispatch_sending_date;
            //$sampleApproval->fit_sample_dispatch_aob_number = $request->fit_sample_dispatch_aob_number;
            $sampleApproval->size_set_approval_plan = $request->size_set_approval_plan;
            $sampleApproval->size_set_approval_actual = $request->size_set_approval_actual;
            //$sampleApproval->size_set_sample_dispatch_details = $request->size_set_sample_dispatch_details;
            //$sampleApproval->size_set_sample_dispatch_sending_date = $request->size_set_sample_dispatch_sending_date;
            //$sampleApproval->size_set_sample_dispatch_aob_number = $request->size_set_sample_dispatch_aob_number;
            $sampleApproval->pp_approval_plan = $request->pp_approval_plan;
            $sampleApproval->pp_approval_actual = $request->pp_approval_actual;
           // $sampleApproval->pp_sample_dispatch_details = $request->pp_sample_dispatch_details;
            //$sampleApproval->pp_sample_sending_date = $request->pp_sample_sending_date;
            //$sampleApproval->pp_sample_courier_aob_number = $request->pp_sample_courier_aob_number;
            $sampleApproval->save();
        
            //DB::commit();
        }

        //PP Meeting Details

        public function savePpMeetingInformation($request, $manualpo){
            //DB::beginTransaction();

            $ppMeeting = new PpMeeting();
            $ppMeeting->po_id=$request->po_id;
            $ppMeeting->po_number=$request->po_number;
            $ppMeeting->care_label_approval_plan = $request->care_label_approval_plan;
            $ppMeeting->care_label_approval_actual = $request->care_label_approval_actual;
            $ppMeeting->material_inhouse_date_plan = $request->material_inhouse_date_plan;
            $ppMeeting->material_inhouse_date_actual = $request->material_inhouse_date_actual;
            $ppMeeting->pp_meeting_date_plan = $request->pp_meeting_date_plan;
            $ppMeeting->pp_meeting_date_actual = $request->pp_meeting_date_actual;
            $ppMeeting->pp_meeting_schedule = $request->pp_meeting_schedule;
            $ppMeeting->save();

            //DB::commit();
        }

        //Production Information

        public function saveProductionInformation($request,$manualpo){

            //DB::beginTransaction();

            $production = new ProductionInformation();
            $production->po_id=$request->po_id;
            $production->po_number=$request->po_number;
            $production->cutting_date_plan = $request->cutting_date_plan;
            $production->cutting_date_actual = $request->cutting_date_actual;
            $production->embellishment_plan = $request->embellishment_plan;
            $production->embellishment_actual = $request->embellishment_actual;
            $production->sewing_start_date_plan = $request->sewing_start_date_plan;
            $production->sewing_start_date_actual = $request->sewing_start_date_actual;
            $production->sewing_complete_date_plan = $request->sewing_complete_date_plan;
            $production->sewing_complete_date_actual = $request->sewing_complete_date_actual;
            $production->washing_complete_date_plan = $request->washing_complete_date_plan;
            $production->washing_complete_date_actual = $request->washing_complete_date_actual;
            $production->finishing_complete_date_plan = $request->finishing_complete_date_plan;
            $production->finishing_complete_date_actual = $request->finishing_complete_date_actual;
            $production->save();

            //DB::commit();
        }


        //Inspection Information
        public function saveInspectionInformation($request,$manualpo){

            //DB::beginTransaction();

            $inspection = new InspectionInformation();
            $inspection->po_number = $request->po_number;
            $inspection->po_id = $request->po_id;
            $inspection->sewing_inline_inspection_date_plan = $request->sewing_inline_inspection_date_plan;
            $inspection->sewing_inline_inspection_date_actual = $request->sewing_inline_inspection_date_actual;
            $inspection->inline_inspection_schedule = $request->inline_inspection_schedule;
            $inspection->finishing_inline_inspection_date_plan = $request->finishing_inline_inspection_date_plan;
            $inspection->finishing_inline_inspection_date_actual = $request->finishing_inline_inspection_date_actual;
            $inspection->pre_final_date_actual = $request->pre_final_date_actual;
            $inspection->pre_final_aql_schedule = $request->pre_final_aql_schedule;
            $inspection->final_aql_date_plan = $request->final_aql_date_plan;
            $inspection->final_aql_date_actual = $request->final_aql_date_actual;
            $inspection->final_aql_schedule=$request->final_aql_schedule;
            $inspection->save();

            //DB::commit();
        }


        //Sample ShippingApproval
        public function saveSampleShippingApproval($request,$manualpo){

            $shippingapproval = new SampleShippingApproval();
            $shippingapproval->po_number = $request->po_number;
            $shippingapproval->po_id = $request->po_id;
            $shippingapproval->production_sample_approval_plan = $request->production_sample_approval_plan;
            $shippingapproval->production_sample_approval_actual = $request->production_sample_approval_actual;
            $shippingapproval->production_sample_dispatch_details = $request->production_sample_dispatch_details;
            $shippingapproval->production_sample_dispatch_sending_date = $request->production_sample_dispatch_sending_date;
            $shippingapproval->production_sample_dispatch_aob_number = $request->production_sample_dispatch_aob_number;
            $shippingapproval->shipment_booking_with_acs_plan = $request->shipment_booking_with_acs_plan;
            $shippingapproval->shipment_booking_with_acs_actual = $request->shipment_booking_with_acs_actual;
            $shippingapproval->sa_approval_plan = $request->sa_approval_plan;
            $shippingapproval->sa_approval_actual = $request->sa_approval_actual;
            $shippingapproval->save();
        }

        public function saveExFactoryVesselInfo($request,$manualpo){

            $exfactory = new ExFactory();
            $exfactory->po_number = $request->po_number;
            $exfactory->po_id=$request->po_id;
            $exfactory->ex_factory_date_po=$request->ex_factory_date_po;
            $exfactory->revised_ex_factory_date=$request->revised_ex_factory_date;
            $exfactory->actual_ex_factory_date=$request->actual_ex_factory_date;
            $exfactory->shipped_units=$request->shipped_units;
            $exfactory->original_eta_sa_date=$request->original_eta_sa_date;
            $exfactory->revised_eta_sa_date=$request->revised_eta_sa_date;
            $exfactory->forwarded_ref_vessel_name=$request->forwarded_ref_vessel_name;
            $exfactory->save();
        }

        public function savePaymentInfo($request,$manualpo){

            $payment = new Payment();
            $payment->po_number = $request->po_number;
            $payment->po_id=$request->po_id;
            $payment->late_delivery_discount=$request->late_delivery_discount;
            $payment->invoice_number=$request->invoice_number;
            $payment->invoice_create_date=$request->invoice_create_date;
            $payment->payment_receive_date=$request->payment_receive_date;
            $payment->save();
        }

     //Save CriticalPath File Info
     public function saveCriticalPathFileInfo($request,$criticalPath){
        $file_path = $this->uploadFile($request, 'file', $this->pogarments_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new CriticalPathMasterFile();
            $data->critical_path_id = $criticalPath->id;
            $data->critical_path_departments_id = $request->critical_path_departments_id ?? "Enter Id";
            $data->file_name    = $request->file_name ?? "Critical_Path_File Upload";
            $data->file_url     = $path;
            $data->type = $request->type;
            $data->save();
        }
    }


        /*
        Show
        */
    public function show(Request $request)
    {
        try{

            $manualpo = ManualPo::find($request->id);
            $this->data = (new ManualPoResource($manualpo));
            $this->apiSuccess("ManualPo Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }


      /*
    Update
    */

    public function update(Request $request){

        try{
            $validator = Validator::make( $request->all(),[
                //'name'          => ["required", "min:4"],
                //'description'   => ["nullable", "min:4"],
            ]);

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

            $manualpo = ManualPo::find($request->id);
            $manualpo->buyer_id = $request->buyer_id;
            $manualpo->vendor_id = $request->vendor_id;
            $manualpo->supplier_id = $request->supplier_id;
            $manualpo->manufacturer_id = $request->manufacturer_id;
            $manualpo->customer_department_id = $request->customer_department_id;
            $manualpo->	note = $request->note;
            $manualpo->terms_conditions = $request->terms_conditions;
            $manualpo->first_delivery_date = $request->first_delivery_date;
            $manualpo->second_shipment_date = $request->second_shipment_date;
            $manualpo->vendor_po_date = $request->vendor_po_date;
            $manualpo->current_buyer_po_price = $request->current_buyer_po_price;
            $manualpo->vendor_po_price = $request->vendor_po_price;
            $manualpo->accessorize_price = $request->accessorize_price;
            $manualpo->plm_no = $request->plm_no;
            $manualpo->description = $request->description;
            $manualpo->fabric_quality = $request->fabric_quality;
            $manualpo->fabric_content = $request->fabric_content;
            $manualpo->fabric_weight=$request->fabric_weight;
            $manualpo->po_no=$request->po_no;
            $manualpo->season_id=$request->season_id;
            $manualpo->save();
            $this->deliveryDetails($request,$manualpo);

            DB::commit();
            $this->apiSuccess();
            $this->data = (new ManualPoResource($manualpo));
            return $this->apiOutput("Manual Po Updated Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


     /*
       Delete
    */
    public function delete(Request $request)
    {
        ManualPo::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("ManualPo Deleted Successfully", 200);
    }

    public function manualPoWithBuyerVenor(Request $request)
    {
        try{
            
            $validator = Validator::make( $request->all(),[
                'vendor_id'    => ['nullable', "exists:vendors,id"],
                'buyer_id'    => ['nullable', "exists:customers,id"],
               
            ]);

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 200);
            }

            $manualpo = ManualPo::orderBy("id", "DESC");
            if( !empty($request->vendor_id) ){
                $manualpo->where("vendor_id", $request->vendor_id);
            }

            if( !empty($request->buyer_id) ){
                $manualpo->where("buyer_id", $request->buyer_id);
            }

            if( !empty($request->buyer_id) ){
                $manualpo->where("buyer_id", $request->buyer_id);
            }
            
            if( !empty($request->customer_department_id)){
                $manualpo->where("customer_department_id", $request->customer_department_id);
            }

            if( !empty($request->ship_method)){
                $manualpo->whereHas("manualpoDeliveryDetails",function($qry) use($request){
                    $qry->where("ship_method",$request->ship_method);
                });
            }
            

            $manualpo = $manualpo->get();
            
            $this->data = ManualPoResource::collection($manualpo);
            $this->apiSuccess("Manual Po Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }


   


}
