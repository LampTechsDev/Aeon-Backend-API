<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LabDipsEmbellishmentInformationResource;
use App\Models\LabDipsEmbellishmentInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class LabDipsEmbellishmentInformationController extends Controller
{
    public function store(Request $request)
    {
     
        try{

            // if(!PermissionController::hasAccess("group_create")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }

            $validator = Validator::make( $request->all(),[
                'name'          => ["required", "min:4"],
                'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $labDips = new LabDipsEmbellishmentInformation();
            $labDips->po_number = $request->po_number ;
            $labDips->po_id = $request->po_id;
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
            $this->apiSuccess();
            $this->data = (new LabDipsEmbellishmentInformationResource($labDips));
            return $this->apiOutput("Group Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
