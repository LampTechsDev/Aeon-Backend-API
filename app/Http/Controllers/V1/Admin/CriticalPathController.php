<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CriticalPathResource;
use App\Models\BulkFabricInformation;
use App\Models\CriticalPath;
use App\Models\CriticalPathMasterFile;
use App\Models\ExFactory;
use App\Models\InspectionInformation;
use App\Models\LabDipsEmbellishmentInformation;
use App\Models\Payment;
use App\Models\PpMeeting;
use App\Models\ProductionInformation;
use App\Models\SampleApprovalInformation;
use App\Models\SampleShippingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class CriticalPathController extends Controller
{


    public function index()
    {
       try{
        //return 10;
            // if(!PermissionController::hasAccess("group_list")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }
            $this->data = CriticalPathResource::collection(CriticalPath::all());
            $this->apiSuccess("Critical Path Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    
      //Additional Critical Path Save File Info
      public function addCriticalPathFile(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"bulk_fabric_information_id"            => ["required","exists:lab_dips_embellishment_information,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $this->saveAdditionalCriticalPathFileInfo($request);
            $this->apiSuccess("Critical Path File Added Successfully");
            return $this->apiOutput();
        
        
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    //Save Additional Critical Path File Info
    public function saveAdditionalCriticalPathFileInfo($request){
        $file_path = $this->uploadFile($request, 'file', $this->pogarments_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new CriticalPathMasterFile();
            $data->critical_path_id = $request->critical_path_id;
            $data->critical_path_departments_id = $request->critical_path_departments_id ?? "Enter Id";
            $data->file_name    = $request->file_name ?? "Critical_Path_File Upload";
            $data->file_url     = $path;
            $data->type = $request->type;
            $data->save();
        }
    }


    public function update(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $criticalPath = CriticalPath::find($request->id);
            // $criticalPath->po_id=$request->po_id;
            // $criticalPath->inspection_information_id=$request->inspection_information_id;
            // $criticalPath->labdips_embellishment_id=$request->labdips_embellishment_id;
            // $criticalPath->bulk_fabric_information_id =$request->bulk_fabric_information_id;
            // $criticalPath->fabric_mill_id = $request->fabric_mill_id;
            // $criticalPath->sample_approval_id=$request->sample_approval_id;
            // $criticalPath->pp_meeting_id=$request->pp_meeting_id;
            // $criticalPath->production_information_id=$request->production_information_id;
            $criticalPath->	lead_times=$request->lead_times;
            $criticalPath->lead_type=$request->lead_type;
            $criticalPath->	official_po_plan=$request->official_po_plan;
            $criticalPath->official_po_actual=$request->official_po_actual;
            $criticalPath->status=$request->status;
            $criticalPath->aeon_comments=$request->aeon_comments;
            $criticalPath->vendor_comments=$request->vendor_comments;
            $criticalPath->other_comments=$request->other_comments;
            $criticalPath->save();
            $this->saveLabDipsEmbellishmentInfo($request);
            $this-> savebulkFabricInformationInfo($request);
            $this->saveSampleApprovalInformation($request);
            $this->savePpMeetingInformation($request);
            $this->saveProductionInformation($request);
            $this->saveInspectionInformation($request);
            $this->saveSampleShippingApproval($request);
            $this->saveExFactoryVesselInfo($request);
            $this->savePaymentInfo($request);
            $this->apiSuccess();
            $this->data = (new CriticalPathResource($criticalPath));
            return $this->apiOutput("Critical Path Department Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

   
    public function show(Request $request)
    {
        try{
            // if(!PermissionController::hasAccess("group_show")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }
            $criticalPath = CriticalPath::find($request->id);
            $this->data = (new CriticalPathResource($criticalPath));
            $this->apiSuccess("Critical Path Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function delete(Request $request)
    {
        CriticalPath::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Critical Path Deleted Successfully", 200);
    }


    public function updateCriticalPathFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = CriticalPathMasterFile::find($request->id);
            
            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->labdips_uploads, null,null,$data->file_url);
            }

            $data->save();
          
            $this->apiSuccess("Critical File Updated Successfully");
            return $this->apiOutput();
           
           
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function deleteFileCriticalPath(Request $request){
        try{
           
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],
            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }
    
            $labDipupload=CriticalPathMasterFile::where('id',$request->id);
            $labDipupload->delete();
            $this->apiSuccess("Critical Path Image Deleted successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    /**
           * LabDipsEmbellishment Department
           * @return int
           */

           public function saveLabDipsEmbellishmentInfo($request){
            //DB::beginTransaction();
            
                    $labDips =  LabDipsEmbellishmentInformation::find($request->id);
                    // $labDips->po_number = $manualpo->po_no;
                    // $labDips->po_id = $manualpo->id;
                    $labDips->colour_std_print_artwork_sent_to_supplier_plan = $request->colour_std_print_artwork_sent_to_supplier_plan;
                    $labDips->colour_std_print_artwork_sent_to_supplier_actual = $request->colour_std_print_artwork_sent_to_supplier_actual;
                    $labDips->lab_dip_approval_plan = $request->lab_dip_approval_plan;
                    $labDips->lab_dip_approval_actual = $request->lab_dip_approval_actual;
                    $labDips->lab_dip_dispatch_details = $request->lab_dip_dispatch_details;
                    $labDips->lab_dip_dispatch_sending_date = $request->lab_dip_dispatch_sending_date;
                    $labDips->lab_dip_dispatch_aob_number = $request->lab_dip_dispatch_aob_number;
                    $labDips->embellishment_so_approval_plan = $request->embellishment_so_approval_plan;
                    $labDips->embellishment_so_approval_actual = $request->embellishment_so_approval_actual;
                    $labDips->embellishment_so_dispatch_details = $request->embellishment_so_dispatch_details;
                    $labDips->embellishment_so_dispatch_sending_date = $request->embellishment_so_dispatch_sending_date;
                    $labDips->embellishment_so_dispatch_aob_number = $request->embellishment_so_dispatch_aob_number;
                    $labDips->save();
                    //return $labDips->id;
               }

               //Bulk Fabric Information
                public function savebulkFabricInformationInfo($request){

                    // DB::beginTransaction();
                    
                    $bulkFabricInformation = BulkFabricInformation::find($request->id);
                    // $bulkFabricInformation->po_number =$manualpo->po_no;
                    // $bulkFabricInformation->po_id = $manualpo->id;
                    $bulkFabricInformation->fabric_ordered_plan = $request->fabric_ordered_plan;
                    $bulkFabricInformation->fabric_ordered_actual = $request->fabric_ordered_actual;
                    $bulkFabricInformation->bulk_fabric_knit_down_approval_plan = $request->bulk_fabric_knit_down_approval_plan;
                    $bulkFabricInformation->bulk_fabric_knit_down_approval_actual = $request->bulk_fabric_knit_down_approval_actual;
                    $bulkFabricInformation->bulk_fabric_knit_down_dispatch_details = $request->bulk_fabric_knit_down_dispatch_details;
                    $bulkFabricInformation->bulk_fabric_knit_down_dispatch_sending_date = $request->bulk_fabric_knit_down_dispatch_sending_date;
                    $bulkFabricInformation->bulk_fabric_knit_down_dispatch_aob_number = $request->bulk_fabric_knit_down_dispatch_aob_number;
                    $bulkFabricInformation->bulk_yarn_fabric_inhouse_plan = $request->bulk_yarn_fabric_inhouse_plan;
                    $bulkFabricInformation->bulk_yarn_fabric_inhouse_actual = $request->bulk_yarn_fabric_inhouse_actual;

                    $bulkFabricInformation->save();
                    //return $bulkFabricInformation->id;
                }

        //Sample Approval Information

        public function saveSampleApprovalInformation($request){
            //DB::beginTransaction();

            $sampleApproval = SampleApprovalInformation::find($request->id);
            // $sampleApproval->po_id=$manualpo->id;
            // $sampleApproval->po_number=$manualpo->po_no;
            $sampleApproval->development_photo_sample_sent_plan = $request->development_photo_sample_sent_plan;
            $sampleApproval->development_photo_sample_sent_actual = $request->development_photo_sample_sent_actual;
            $sampleApproval->development_photo_sample_dispatch_details = $request->development_photo_sample_dispatch_details;
            $sampleApproval->fit_approval_plan = $request->fit_approval_plan;
            $sampleApproval->fit_approval_actual = $request->fit_approval_actual;
            $sampleApproval->fit_sample_dispatch_details = $request->fit_sample_dispatch_details;
            $sampleApproval->fit_sample_dispatch_sending_date = $request->fit_sample_dispatch_sending_date;
            $sampleApproval->fit_sample_dispatch_aob_number = $request->fit_sample_dispatch_aob_number;
            $sampleApproval->size_set_approval_plan = $request->size_set_approval_plan;
            $sampleApproval->size_set_approval_actual = $request->size_set_approval_actual;
            $sampleApproval->size_set_sample_dispatch_details = $request->size_set_sample_dispatch_details;
            $sampleApproval->size_set_sample_dispatch_sending_date = $request->size_set_sample_dispatch_sending_date;
            $sampleApproval->size_set_sample_dispatch_aob_number = $request->size_set_sample_dispatch_aob_number;
            $sampleApproval->pp_approval_plan = $request->pp_approval_plan;
            $sampleApproval->pp_approval_actual = $request->pp_approval_actual;
            $sampleApproval->pp_sample_dispatch_details = $request->pp_sample_dispatch_details;
            $sampleApproval->pp_sample_sending_date = $request->pp_sample_sending_date;
            $sampleApproval->pp_sample_courier_aob_number = $request->pp_sample_courier_aob_number;
            $sampleApproval->save();
        
            //return $sampleApproval->id;
        }

        //PP Meeting Details

        public function savePpMeetingInformation($request){
            //DB::beginTransaction();
            $ppMeeting = PpMeeting::find($request->id);
            // $ppMeeting->po_id=$manualpo->id;
            // $ppMeeting->po_number=$manualpo->po_no;
            $ppMeeting->care_label_approval_plan = $request->care_label_approval_plan;
            $ppMeeting->care_label_approval_actual = $request->care_label_approval_actual;
            $ppMeeting->material_inhouse_date_plan = $request->material_inhouse_date_plan;
            $ppMeeting->material_inhouse_date_actual = $request->material_inhouse_date_actual;
            $ppMeeting->pp_meeting_date_plan = $request->pp_meeting_date_plan;
            $ppMeeting->pp_meeting_date_actual = $request->pp_meeting_date_actual;
            $ppMeeting->pp_meeting_schedule = $request->pp_meeting_schedule;
            $ppMeeting->save();

            //return $ppMeeting->id;
        }

        //Production Information

        public function saveProductionInformation($request){
            //DB::beginTransaction();
            $production = ProductionInformation::find($request->id);
            // $production->po_id=$manualpo->id;
            // $production->po_number=$manualpo->po_no;
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

            //return $production->id;
        }

                //Inspection Information
                public function saveInspectionInformation($request){
                    //DB::beginTransaction();
                    $inspection = InspectionInformation::find($request->id);
                    // $inspection->po_number = $manualpo->po_no;
                    // $inspection->po_id = $manualpo->id;
                    $inspection->sewing_inline_inspection_date_plan = $request->sewing_inline_inspection_date_plan;
                    $inspection->sewing_inline_inspection_date_actual = $request->sewing_inline_inspection_date_actual;
                    $inspection->inline_inspection_schedule = $request->inline_inspection_schedule;
                    $inspection->finishing_inline_inspection_date_plan = $request->finishing_inline_inspection_date_plan;
                    $inspection->finishing_inline_inspection_date_actual = $request->finishing_inline_inspection_date_actual;
                    $inspection->pre_final_date_plan = $request->pre_final_date_plan;
                    $inspection->pre_final_date_actual = $request->pre_final_date_actual;
                    $inspection->pre_final_aql_schedule = $request->pre_final_aql_schedule;
                    $inspection->final_aql_date_plan = $request->final_aql_date_plan;
                    $inspection->final_aql_date_actual = $request->final_aql_date_actual;
                    $inspection->final_aql_schedule=$request->final_aql_schedule;
                    $inspection->save();
        
                    //return $inspection->id;
                }
        
        
                //Sample ShippingApproval
                public function saveSampleShippingApproval($request){
                    $shippingapproval = SampleShippingApproval::find($request->id);
                    // $shippingapproval->po_number = $manualpo->po_no;
                    // $shippingapproval->po_id = $manualpo->id;
                    $shippingapproval->production_sample_approval_plan = $request->production_sample_approval_plan;
                    $shippingapproval->production_sample_approval_actual = $request->roduction_sample_approval_actual;
                    //$shippingapproval->production_sample_dispatch_details = $request->;
                    $shippingapproval->production_sample_dispatch_sending_date = $request->production_sample_dispatch_sending_date;
                    $shippingapproval->production_sample_dispatch_aob_number = $request->production_sample_dispatch_aob_number;
                    $shippingapproval->shipment_booking_with_acs_plan = $request->shipment_booking_with_acs_plan;
                    $shippingapproval->shipment_booking_with_acs_actual = $request->shipment_booking_with_acs_actual;
                    $shippingapproval->sa_approval_plan = $request->sa_approval_plan;
                    $shippingapproval->sa_approval_actual = $request->sa_approval_actual;
                    $shippingapproval->save();
                    //return $shippingapproval->id;
                }
        
                public function saveExFactoryVesselInfo($request){
                    $exfactory = ExFactory::find($request->id);
                    // $exfactory->po_number = $manualpo->po_no;
                    // $exfactory->po_id=$manualpo->id;
                    $exfactory->ex_factory_date_po=$request->ex_factory_date_po;
                    $exfactory->revised_ex_factory_date=$request->revised_ex_factory_date;
                    $exfactory->actual_ex_factory_date=$request->actual_ex_factory_date;
                    $exfactory->shipped_units=$request->shipped_units;
                    $exfactory->original_eta_sa_date=$request->original_eta_sa_date;
                    $exfactory->revised_eta_sa_date=$request->revised_eta_sa_date;
                    $exfactory->forwarded_ref_vessel_name=$request->forwarded_ref_vessel_name;
                    $exfactory->save();
                    //return $exfactory->id;
                }
        
                public function savePaymentInfo($request){
                    $payment = Payment::find($request->id);
                    // $payment->po_number = $manualpo->po_no;
                    // $payment->po_id=$manualpo->id;
                    $payment->late_delivery_discount=$request->late_delivery_discount;
                    $payment->invoice_number=$request->invoice_number;
                    $payment->invoice_create_date=$request->invoice_create_date;
                    $payment->payment_receive_date=$request->payment_receive_date;
                    $payment->save();
                    //return $payment->id;
                }



}
