<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Mill;
use App\Models\Payment;
use App\Models\ManualPo;
use App\Models\ExFactory;
use App\Models\PoArtwork;
use App\Models\PpMeeting;
use App\Models\CriticalPath;
use Illuminate\Http\Request;
use App\Models\BusinessSummary;
use App\Models\FreightManagement;
use App\Models\PoPictureGarments;
use Illuminate\Support\Facades\DB;
use App\Models\ManualPoItemDetails;
use App\Http\Controllers\Controller;
use App\Models\BulkFabricInformation;
use App\Models\InspectionInformation;
use App\Models\ProductionInformation;
use App\Models\CriticalPathMasterFile;
use App\Models\SampleShippingApproval;
use App\Models\ManualPoDeliveryDetails;
use App\Http\Resources\ManualPoResource;
use App\Models\SampleApprovalInformation;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CriticalPathResource;
use App\Models\LabDipsEmbellishmentInformation;
use App\Models\InspectionManagementOrderDetails;
use App\Http\Resources\FreightManagementResource;
use App\Models\Invoice;

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
                    'po_no'             => 'required|unique:manual_pos,po_no',
                 ]

            );

            DB::beginTransaction();

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }

            $manualpo = new ManualPo();
            $manualpo->buyer_id               = $request->buyer_id;
            $manualpo->vendor_id              = $request->vendor_id;
            $manualpo->supplier_id            = $request->supplier_id;
            $manualpo->manufacturer_id        = $request->manufacturer_id;
            $manualpo->customer_department_id = $request->customer_department_id;
            $manualpo->	note                  = $request->note;
            $manualpo->terms_conditions       = $request->terms_conditions;
            $manualpo->first_delivery_date    = $request->first_delivery_date;
            $manualpo->second_shipment_date   = $request->second_shipment_date;
            $manualpo->vendor_po_date         = $request->vendor_po_date;
            $manualpo->current_buyer_po_price = $request->current_buyer_po_price;
            $manualpo->vendor_po_price        = $request->vendor_po_price;
            $manualpo->accessorize_price      = $request->accessorize_price;
            $manualpo->plm_no                 = $request->plm_no;
            $manualpo->description            = $request->description;
            $manualpo->fabric_quality         = $request->fabric_quality;
            $manualpo->fabric_content         = $request->fabric_content;
            $manualpo->currency               = $request->currency;
            $manualpo->payment_method         = $request->payment_method;
            $manualpo->payment_terms          = $request->payment_terms;
            $manualpo->fabric_weight          = $request->fabric_weight;
            $manualpo->po_no                  = $request->po_no;
            $manualpo->season_id              = $request->season_id;
            $manualpo->fabric_type            = $request->fabric_type;
            $manualpo->po_type                = $request->po_type;
            $manualpo->supplier_no            = $request->supplier_no;
            $manualpo->total_value            = $request->total_value;
            $manualpo->total_quantity         = $request->total_quantity;
            $manualpo->save();
            $this->saveFileInfo($request, $manualpo);
            $this->saveExtraFileInfo($request, $manualpo);
            $this->deliveryDetails($request,$manualpo);
            $this->saveCriticalPath($request,$manualpo);

            $this->businessSummaryDetails($request,$manualpo);

            DB::commit();
            $this->apiSuccess();
            $this->data = (new ManualPoResource($manualpo));
            return $this->apiOutput("Manual Po Added Successfully");

        }catch(Exception $e){
            //return $this->apiOutput($this->getError( $e), 500);

            //dd($this->getError($e));
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

    // Save Business Summary Info
    public function businessSummaryDetails($request, $manualpo){

        $data = new BusinessSummary();
        $data->po_id = $manualpo->id;
        $data->save();
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


            $criticalPath = new CriticalPath();

            $lab_dips_embellishment_id = $this->saveLabDipsEmbellishmentInfo($request, $manualpo);
            $bulk_fabric_information = $this->savebulkFabricInformationInfo($request, $manualpo);
            $sample_approval_information = $this->saveSampleApprovalInformation($request, $manualpo);
            $pp_meeting_information = $this->savePpMeetingInformation($request, $manualpo);
            $production_information = $this->saveProductionInformation($request, $manualpo);
            $inspection_information = $this->saveInspectionInformation($request,$manualpo);
            $sample_shipping_approval = $this->saveSampleShippingApproval($request,$manualpo);
            $ex_factory_vessel_info = $this->saveExFactoryVesselInfo($request,$manualpo);
            $payment_info = $this->savePaymentInfo($request,$manualpo);
            //$mill_info = $this->saveMillInfo($request,$manualpo);

            $criticalPath->po_id = $manualpo->id;
            $criticalPath->inspection_information_id=$inspection_information;
            $criticalPath->labdips_embellishment_id = $lab_dips_embellishment_id;
            $criticalPath->bulk_fabric_information_id =$bulk_fabric_information;
            //$criticalPath->fabric_mill_id = $mill_info;
            $criticalPath->sample_approval_id=$sample_approval_information;
            $criticalPath->pp_meeting_id=$pp_meeting_information;
            $criticalPath->production_information_id=$production_information;
            $criticalPath->production_information_id=$inspection_information;
            $criticalPath->sample_shipping_approvals_id=$sample_shipping_approval;
            $criticalPath->ex_factories_id=$ex_factory_vessel_info;
            $criticalPath->payments_id=$payment_info;
            //Lead Time Calculation
            $ex_factory_date=strtotime($manualpo->vendor_po_date);

            // $currentDate = Carbon::now()->toDateString();
            // $currentDate2 = Carbon::now()->toDateString();

            //$differece_date = dateDiffInDays($ex_factory_date,$currentDate);

            //dd($currentDate

            $current_date=Carbon::now();
            $current_date1=strtotime($current_date);
            //dd($current_date1);
            //dd($current_date1);
            //dd($current_date);
            //$subtractedDate = $currentDate->subDays(7);
            //$current_time1=strtotime($current_time);
            //dd($current_time1);
            //$current_time1=strtotime($current_time);
            //$criticalPath->official_po_actual=Carbon::now();
            //$official_po_actual1= $criticalPath->official_po_actual;

            //dd($ex_factory_date);
            //$days = $current_date->diffInDays($ex_factory_date);
            $days = (int)(($ex_factory_date - $current_date1)/86400);
            //dd($days);
            $criticalPath->lead_times= $days;
            $lead_time=$criticalPath->lead_times;
            //dd($lead_time);
            if($manualpo->fabric_type == "solid" && $lead_time>=90){
                $criticalPath->lead_type="Regular";

            }else{
                $criticalPath->lead_type="Short";
            }


            if($manualpo->fabric_type == "aop" && $lead_time>=90){
                $criticalPath->lead_type="Regular";

            }else{
                $criticalPath->lead_type="Short";
            }

            if($manualpo->fabric_type == "import" && $lead_time>=120){
                $criticalPath->lead_type="Regular";

            }else{
                $criticalPath->lead_type="Short";
            }
            //$criticalPath->lead_type=$request->lead_type;
            //Official Pos Sent(Plan)
            $ex_factory_date1=strtotime($manualpo->vendor_po_date);
            $ex_factory_date2=strtotime($manualpo->vendor_po_date);
            $ex_factory_date3=strtotime($manualpo->vendor_po_date);
            if($manualpo->fabric_type=="solid"){

                $fabric_ordered_plan1=Carbon::parse($ex_factory_date1)->subDays(73)->format("Y-m-d");
                $criticalPath->official_po_plan= Carbon::parse($fabric_ordered_plan1)->subDays(15)->format("Y-m-d");

            }
            elseif($manualpo->fabric_type=="aop"){
                $fabric_ordered_plan1=Carbon::parse($ex_factory_date2)->subDays(83)->format("Y-m-d");
                $criticalPath->official_po_plan= Carbon::parse($fabric_ordered_plan1)->subDays(15)->format("Y-m-d");
            }
            elseif($manualpo->fabric_type=="import"){

                $fabric_ordered_plan1=Carbon::parse($ex_factory_date3)->subDays(108)->format("Y-m-d");
                $criticalPath->official_po_plan= Carbon::parse($fabric_ordered_plan1)->subDays(15)->format("Y-m-d");

            }



            //$criticalPath->status=$request->status;
            $criticalPath->aeon_comments=$request->aeon_comments;
            $criticalPath->vendor_comments=$request->vendor_comments;
            $criticalPath->other_comments=$request->other_comments;
            $criticalPath->save();

            $this->saveFreightManagementInfo($request, $criticalPath);
            $this->saveInspectionOrderDetailsInfo($request, $criticalPath);
            $this->saveInvoiceInfo($request, $criticalPath);

    }


          /**
           * LabDipsEmbellishment Department
           * @return int
           */

            public function saveLabDipsEmbellishmentInfo($request, $manualpo){
                    //DB::beginTransaction();

                    $labDips = new LabDipsEmbellishmentInformation();
                    $labDips->po_number = $manualpo->po_no;
                    $labDips->po_id = $manualpo->id;
                    //Embellishment/so Approval Plan Calculation
                    $pp_meeting_approval=strtotime($manualpo->vendor_po_date);
                    $pp_meeting_approval1 = Carbon::parse($pp_meeting_approval)->subDays(49)->format("Y-m-d");
                    $labDips->embellishment_so_approval_plan = Carbon::parse($pp_meeting_approval1)->subDays(14)->format("Y-m-d");



                    $embellishment_so_approval_plan1=$labDips->embellishment_so_approval_plan;
                    $embellishment_so_approval_plan2=$labDips->embellishment_so_approval_plan;

                    //Lab Dip Approval Plan Calculation
                    $labDips->lab_dip_approval_plan = Carbon::parse($embellishment_so_approval_plan1)->subDays(7)->format("Y-m-d");

                    //Colour std/print artwork artwork Calculation
                    $labDips->colour_std_print_artwork_sent_to_supplier_plan = Carbon::parse($embellishment_so_approval_plan2)->subDays(7)->format("Y-m-d");

                    $labDips->colour_std_print_artwork_sent_to_supplier_actual = $manualpo->vendor_po_date;

                    $labDips->lab_dip_approval_actual = $manualpo->vendor_po_date;
                    //$labDips->lab_dip_dispatch_details = $request->lab_dip_dispatch_details;
                    $labDips->lab_dip_dispatch_sending_date = $manualpo->vendor_po_date;
                    //$labDips->lab_dip_dispatch_aob_number = $request->lab_dip_dispatch_aob_number;

                    $labDips->embellishment_so_approval_actual = $manualpo->vendor_po_date;
                    //$labDips->embellishment_so_dispatch_details = $request->embellishment_so_dispatch_details;
                    $labDips->embellishment_so_dispatch_sending_date = $manualpo->vendor_po_date;
                    //$labDips->embellishment_so_dispatch_aob_number = $request->embellishment_so_dispatch_aob_number;
                    $labDips->save();
                    return $labDips->id;
        }

        //Bulk Fabric Information
        public function savebulkFabricInformationInfo($request, $manualpo){

               // DB::beginTransaction();

                $bulkFabricInformation = new BulkFabricInformation();
                $bulkFabricInformation->po_number =$manualpo->po_no;
                $bulkFabricInformation->po_id = $manualpo->id;
                //Fabric Inhouse Plan Calculation
                $fabric_inhouse_plan=strtotime($manualpo->vendor_po_date);
                $cutting_date_plan1 = Carbon::parse($fabric_inhouse_plan)->subDays(36)->format("Y-m-d");
                $bulkFabricInformation->bulk_yarn_fabric_inhouse_plan = Carbon::parse($cutting_date_plan1)->subDays(7)->format("Y-m-d");
                $bulk_yarn_fabric_inhouse_plan1=$bulkFabricInformation->bulk_yarn_fabric_inhouse_plan;
                $bulk_yarn_fabric_inhouse_plan2=$bulkFabricInformation->bulk_yarn_fabric_inhouse_plan;
                $bulk_yarn_fabric_inhouse_plan3=$bulkFabricInformation->bulk_yarn_fabric_inhouse_plan;
                $bulk_yarn_fabric_inhouse_plan4=$bulkFabricInformation->bulk_yarn_fabric_inhouse_plan;
                $bulk_yarn_fabric_inhouse_plan5=$bulkFabricInformation->bulk_yarn_fabric_inhouse_plan;
                $bulk_yarn_fabric_inhouse_plan6=$bulkFabricInformation->bulk_yarn_fabric_inhouse_plan;
                //Bulk Fabric/Knit Down Approval Plan Calculation
                if($manualpo->fabric_type=="solid"){
                    $bulkFabricInformation->bulk_fabric_knit_down_approval_plan = Carbon::parse($bulk_yarn_fabric_inhouse_plan1)->subDays(15)->format("Y-m-d");
                }
                elseif($manualpo->fabric_type=="aop"){
                    $bulkFabricInformation->bulk_fabric_knit_down_approval_plan = Carbon::parse($bulk_yarn_fabric_inhouse_plan2)->subDays(25)->format("Y-m-d");
                }
                elseif($manualpo->fabric_type=="import"){
                    $bulkFabricInformation->bulk_fabric_knit_down_approval_plan = Carbon::parse($bulk_yarn_fabric_inhouse_plan3)->subDays(45)->format("Y-m-d");
                }

                //Fabric Order Plan Calculation
                if($manualpo->fabric_type=="solid"){
                    $bulkFabricInformation->fabric_ordered_plan = Carbon::parse($bulk_yarn_fabric_inhouse_plan4)->subDays(30)->format("Y-m-d");
                }
                elseif($manualpo->fabric_type=="aop"){
                    $bulkFabricInformation->fabric_ordered_plan = Carbon::parse($bulk_yarn_fabric_inhouse_plan5)->subDays(40)->format("Y-m-d");
                }
                elseif($manualpo->fabric_type=="import"){
                    $bulkFabricInformation->fabric_ordered_plan = Carbon::parse($bulk_yarn_fabric_inhouse_plan6)->subDays(65)->format("Y-m-d");
                }

                //$bulkFabricInformation->fabric_ordered_plan = $manualpo->vendor_po_date;
                $bulkFabricInformation->fabric_ordered_actual = $manualpo->vendor_po_date;

                $bulkFabricInformation->bulk_fabric_knit_down_approval_actual = $manualpo->vendor_po_date;
                //$bulkFabricInformation->bulk_fabric_knit_down_dispatch_details = $request->bulk_fabric_knit_down_dispatch_details;
                //$bulkFabricInformation->bulk_fabric_knit_down_dispatch_sending_date = $request->bulk_fabric_knit_down_dispatch_sending_date;
                //$bulkFabricInformation->bulk_fabric_knit_down_dispatch_aob_number = $request->bulk_fabric_knit_down_dispatch_aob_number;
                //Fabric Inhouse Plan Calculation


                $bulkFabricInformation->bulk_yarn_fabric_inhouse_actual = $manualpo->vendor_po_date;

                $bulkFabricInformation->save();
                return $bulkFabricInformation->id;
        }

        //Sample Approval Information

        public function saveSampleApprovalInformation($request, $manualpo){
            //DB::beginTransaction();

            $sampleApproval = new SampleApprovalInformation();
            $sampleApproval->po_id=$manualpo->id;
            $sampleApproval->po_number=$manualpo->po_no;
            //PP Approval Plan Calculation
            $pp_meeting=strtotime($manualpo->vendor_po_date);
            $pp_meeting_1 = Carbon::parse($pp_meeting)->subDays(39)->format("Y-m-d");
            $sampleApproval->pp_approval_plan = Carbon::parse($pp_meeting_1)->subDays(10)->format("Y-m-d");
            $pp_approval_plan1=$sampleApproval->pp_approval_plan;
            //Size Set Approval Plan Calculation
            $sampleApproval->size_set_approval_plan = Carbon::parse($pp_approval_plan1)->subDays(14)->format("Y-m-d");
            $size_set_approval_plan1=$sampleApproval->size_set_approval_plan;

            //Fit Approval Plan Calculation
            $sampleApproval->fit_approval_plan = Carbon::parse($size_set_approval_plan1)->subDays(14)->format("Y-m-d");
            $fit_approval_plan1=$sampleApproval->fit_approval_plan;

            //Photo Sample Sent Plan Calculation

            $sampleApproval->development_photo_sample_sent_plan = Carbon::parse($fit_approval_plan1)->subDays(10)->format("Y-m-d");
            $sampleApproval->development_photo_sample_sent_actual = $manualpo->vendor_po_date;
            //$sampleApproval->development_photo_sample_dispatch_details = $request->first_delivery_date;

            $sampleApproval->fit_approval_actual = $manualpo->vendor_po_date;
            //$sampleApproval->fit_sample_dispatch_details = $request->fit_sample_dispatch_details;
            //$sampleApproval->fit_sample_dispatch_sending_date = $request->fit_sample_dispatch_sending_date;
            //$sampleApproval->fit_sample_dispatch_aob_number = $request->fit_sample_dispatch_aob_number;

            $sampleApproval->size_set_approval_actual = $manualpo->vendor_po_date;
            //$sampleApproval->size_set_sample_dispatch_details = $request->size_set_sample_dispatch_details;
            //$sampleApproval->size_set_sample_dispatch_sending_date = $request->size_set_sample_dispatch_sending_date;
            //$sampleApproval->size_set_sample_dispatch_aob_number = $request->size_set_sample_dispatch_aob_number;


            $sampleApproval->pp_approval_actual = $manualpo->vendor_po_date;
           // $sampleApproval->pp_sample_dispatch_details = $request->pp_sample_dispatch_details;
            //$sampleApproval->pp_sample_sending_date = $request->pp_sample_sending_date;
            //$sampleApproval->pp_sample_courier_aob_number = $request->pp_sample_courier_aob_number;
            $sampleApproval->save();

            return $sampleApproval->id;
        }

        //PP Meeting Details

        public function savePpMeetingInformation($request, $manualpo){
                //DB::beginTransaction();
                $ppMeeting = new PpMeeting();
                $ppMeeting->po_id=$manualpo->id;
                $ppMeeting->po_number=$manualpo->po_no;

                //PP Meeting Plan Calculation
                $pp_meeting1=strtotime($manualpo->vendor_po_date);
                $cutting_date_plan = Carbon::parse($pp_meeting1)->subDays(36)->format("Y-m-d");
                $ppMeeting->pp_meeting_date_plan = Carbon::parse($cutting_date_plan)->subDays(3)->format("Y-m-d");
                $pp_meeting_date_plan1=$ppMeeting->pp_meeting_date_plan;
                $pp_meeting_date_plan2=$ppMeeting->pp_meeting_date_plan;

                //Material Inhouse Date plan Calculation
                $ppMeeting->material_inhouse_date_plan = Carbon::parse($pp_meeting_date_plan1)->subDays(2)->format("Y-m-d");

                //Care Label Approval Plan Calculation
                $ppMeeting->care_label_approval_plan = Carbon::parse($pp_meeting_date_plan2)->subDays(10)->format("Y-m-d");

                $ppMeeting->care_label_approval_actual = $manualpo->vendor_po_date;

                $ppMeeting->material_inhouse_date_actual = $manualpo->vendor_po_date;

                $ppMeeting->pp_meeting_date_actual = $manualpo->vendor_po_date;
                $ppMeeting->pp_meeting_schedule = $manualpo->vendor_po_date;
                $ppMeeting->save();

                return $ppMeeting->id;
        }

        //Production Information

        public function saveProductionInformation($request,$manualpo){
            //DB::beginTransaction();
            //dd($final_aql_plan2);
            $production = new ProductionInformation();
            $production->po_id=$manualpo->id;
            $production->po_number=$manualpo->po_no;
            //Finishing Complete Date Plan Calculation
             $finishing_complete_date=strtotime($manualpo->vendor_po_date);
             $production->finishing_complete_date_plan = Carbon::parse($finishing_complete_date)->subDays(9)->format("Y-m-d");
             $finishing_complete_date1=$production->finishing_complete_date_plan;

             //Washing Complete Date Paln Calculation
             $production->washing_complete_date_plan = Carbon::parse($finishing_complete_date1)->subDays(5)->format("Y-m-d");
             $washing_complete_date_plan1=$production->washing_complete_date_plan;
             $washing_complete_date_plan2=$production->washing_complete_date_plan;

             //Sewing Start Date Plan Calculation
             $production->sewing_start_date_plan = Carbon::parse($washing_complete_date_plan1)->subDays(15)->format("Y-m-d");
             $sewing_start_date_plan1=$production->sewing_start_date_plan;


             //Sewing Complete Date Plan Calculation
             $production->sewing_complete_date_plan = Carbon::parse($washing_complete_date_plan2)->subDays(2)->format("Y-m-d");

             //Emblishment Plan Calculation
             $production->embellishment_plan = Carbon::parse($sewing_start_date_plan1)->subDays(5)->format("Y-m-d");
             $embellishment_plan1=$production->embellishment_plan;

             //Cutting Date Plan calculation
             $production->cutting_date_plan = Carbon::parse($embellishment_plan1)->subDays(2)->format("Y-m-d");


             $production->cutting_date_actual = $manualpo->vendor_po_date;

             $production->embellishment_actual = $manualpo->vendor_po_date;

             $production->sewing_start_date_actual = $manualpo->vendor_po_date;

             $production->sewing_complete_date_actual = $manualpo->vendor_po_date;

             $production->washing_complete_date_actual = $manualpo->vendor_po_date;
            //$production->finishing_complete_date_plan = Carbon::parse($final_aql_plan2)->subDays(2)->format("Y-m-d");

            $production->finishing_complete_date_actual = $manualpo->vendor_po_date;
            $production->save();

            return $production->id;
        }


        //Inspection Information
        public function saveInspectionInformation($request,$manualpo){
            //DB::beginTransaction();
            $inspection = new InspectionInformation();

            $inspection->po_number = $manualpo->po_no;
            $inspection->po_id = $manualpo->id;

            $final_aql = strtotime($manualpo->vendor_po_date);
            $inspection->final_aql_date_plan = Carbon::parse($final_aql)->subDays(7)->format("Y-m-d");

            $final_aql_plan1= $inspection->final_aql_date_plan;
            $final_aql_plan2 = strtotime($final_aql_plan1);
            $inspection->pre_final_date_plan = Carbon::parse($final_aql_plan2)->subDays(3)->format("Y-m-d");

            $inspection->finishing_inline_inspection_date_plan = Carbon::parse($final_aql_plan2)->subDays(3)->format("Y-m-d");

            $sewing_inline_date=$inspection->finishing_inline_inspection_date_plan;
            $inspection->sewing_inline_inspection_date_plan = Carbon::parse($sewing_inline_date)->subDays(4)->format("Y-m-d");


            $inspection->sewing_inline_inspection_date_actual = $manualpo->vendor_po_date;
            $inspection->inline_inspection_schedule = $manualpo->vendor_po_date;

            $inspection->finishing_inline_inspection_date_actual = $manualpo->vendor_po_date;

            $inspection->pre_final_date_actual = $manualpo->vendor_po_date;
            $inspection->pre_final_aql_schedule = $manualpo->vendor_po_date;

            $inspection->final_aql_date_actual = $manualpo->vendor_po_date;
            $inspection->final_aql_schedule=$manualpo->vendor_po_date;
            $inspection->save();

            //$this->saveProductionInformation($manualpo,$final_aql_plan2);



            return $inspection->id;
        }


        //Sample ShippingApproval
        public function saveSampleShippingApproval($request,$manualpo){
            $shippingapproval = new SampleShippingApproval();
            $shippingapproval->po_number = $manualpo->po_no;
            $shippingapproval->po_id = $manualpo->id;
            $shippingapproval->production_sample_approval_actual = $manualpo->vendor_po_date;
            //$shippingapproval->production_sample_dispatch_details = $request->;
            //$shippingapproval->production_sample_dispatch_sending_date = $manualpo->first_delivery_date;
            //$shippingapproval->production_sample_dispatch_aob_number = $request->production_sample_dispatch_aob_number;
            $timestamp3 = strtotime($manualpo->vendor_po_date);
            $shippingapproval->shipment_booking_with_acs_plan = Carbon::parse($timestamp3)->subDays(19)->format("Y-m-d");
            $shippingapproval->shipment_booking_with_acs_actual = $manualpo->vendor_po_date;
            $timestamp2 = strtotime($manualpo->vendor_po_date);
            $shippingapproval->sa_approval_plan = Carbon::parse($timestamp2)->subDays(5)->format("Y-m-d");
            $shippingapproval->sa_approval_actual = $manualpo->vendor_po_date;

            $timestamp5=$shippingapproval->sa_approval_plan;
            $timestamp4 = strtotime($timestamp5);
            $shippingapproval->production_sample_approval_plan = Carbon::parse($timestamp4)->subDays(4)->format("Y-m-d");
            //$shippingapproval->production_sample_approval_plan = $manualpo->vendor_po_date;
            $shippingapproval->save();
            return $shippingapproval->id;
        }

        public function saveExFactoryVesselInfo($request,$manualpo){
            $exfactory = new ExFactory();
            $exfactory->po_number = $manualpo->po_no;
            $exfactory->po_id=$manualpo->id;
            $exfactory->ex_factory_date_po=$manualpo->vendor_po_date;
            $exfactory->revised_ex_factory_date=$manualpo->vendor_po_date;
            $exfactory->actual_ex_factory_date=$manualpo->vendor_po_date;
            $exfactory->shipped_units=$manualpo->vendor_po_date;
            $timestamp = strtotime($manualpo->vendor_po_date);
            $exfactory->original_eta_sa_date = Carbon::parse($timestamp)->addDays(52)->format("Y-m-d");
            $timestamp1 = strtotime($manualpo->vendor_po_date);
            $exfactory->revised_eta_sa_date = Carbon::parse($timestamp1)->addDays(52)->format("Y-m-d");
            $exfactory->forwarded_ref_vessel_name=$manualpo->vendor_po_date;
            $exfactory->save();
            return $exfactory->id;
        }

        public function savePaymentInfo($request,$manualpo){
            $payment = new Payment();
            $payment->po_number = $manualpo->po_no;
            $payment->po_id=$manualpo->id;
            $payment->late_delivery_discount=$manualpo->vendor_po_date;
            $payment->invoice_number=$manualpo->vendor_po_date;
            $payment->invoice_create_date=$manualpo->vendor_po_date;
            $payment->payment_receive_date=$manualpo->vendor_po_date;
            $payment->save();
            return $payment->id;
        }

        // public function saveMillInfo($request,$manualpo){

        //     $mill = new Mill();
        //     $mill->name = $request->name ;
        //     $mill->remarks = $request->remarks;
        //     $mill->status = $request->status;
        //     $mill->save();
        //     return $mill->id;
        // }

        public function saveFreightManagementInfo($request, $criticalPath){
            $freight = new FreightManagement();
            $freight->critical_path_id = $criticalPath->id;
            $freight->save();

        }

        public function saveInspectionOrderDetailsInfo($request,$criticalPath){
            $freight = new InspectionManagementOrderDetails();
            $freight->critical_path_id = $criticalPath->id;
            $freight->save();

        }
        public function saveInvoiceInfo($request,$criticalPath){
            $invoice = new Invoice();
            $invoice->critical_path_id = $criticalPath->id;
            $invoice->save();

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
            $manualpo->buyer_id               = $request->buyer_id;
            $manualpo->vendor_id              = $request->vendor_id;
            $manualpo->supplier_id            = $request->supplier_id;
            $manualpo->manufacturer_id        = $request->manufacturer_id;
            $manualpo->customer_department_id = $request->customer_department_id;
            $manualpo->note                   = $request->note;
            $manualpo->terms_conditions       = $request->terms_conditions;
            $manualpo->first_delivery_date    = $request->first_delivery_date;
            $manualpo->second_shipment_date   = $request->second_shipment_date;
            $manualpo->vendor_po_date         = $request->vendor_po_date;
            $manualpo->current_buyer_po_price = $request->current_buyer_po_price;
            $manualpo->vendor_po_price        = $request->vendor_po_price;
            $manualpo->accessorize_price      = $request->accessorize_price;
            $manualpo->plm_no                 = $request->plm_no;
            $manualpo->description            = $request->description;
            $manualpo->fabric_quality         = $request->fabric_quality;
            $manualpo->fabric_content         = $request->fabric_content;
            $manualpo->fabric_weight          = $request->fabric_weight;
            $manualpo->po_no                  = $request->po_no;
            $manualpo->season_id              = $request->season_id;
            $manualpo->total_value            = $request->total_value;
            $manualpo->total_quantity         = $request->total_quantity;
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

    public function updatePoArtWorkFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = PoArtwork::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->poartworks_uploads, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("Po ArtWork File Updated Successfully");
            return $this->apiOutput();


        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function updatePoPictureGarments(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = PoPictureGarments::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->pogarments_uploads, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("Po Picture Garments File Updated Successfully");
            return $this->apiOutput();


        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }





}
