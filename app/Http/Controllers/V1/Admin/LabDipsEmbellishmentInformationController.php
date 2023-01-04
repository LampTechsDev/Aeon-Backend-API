<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LabDipsEmbellishmentInformationResource;
use App\Models\EmbellishmentImage;
use App\Models\LabDipImage;
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
            $this->saveLabDipFileInfo($request, $labDips);
            $this->saveEmbellishmentFileInfo($request, $labDips);
            $this->apiSuccess();
            $this->data = (new LabDipsEmbellishmentInformationResource($labDips));
            return $this->apiOutput("Group Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

     //LabDip Save File Info
     public function saveLabDipFileInfo($request, $labDips){
        $file_path = $this->uploadFile($request, 'labDipsfile', $this->labdips_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new LabDipImage();
            $data->labdips_embellishment_id = $labDips->id;
            $data->file_name    = $request->lab_dip_file_name ?? "LabDipImage File Upload";
            $data->file_url     = $path;
            $data->type = $request->lab_dip_file_type;
            $data->save();
        }
    }

    //Embellishment Save File Info
    public function saveEmbellishmentFileInfo($request, $labDips){
        $file_path = $this->uploadFile($request, 'embellishmentfile', $this->labdips_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new EmbellishmentImage();
            $data->labdips_embellishment_id = $labDips->id;
            $data->file_name    = $request->embellishment_file_name ?? "EmbellishmentImage File Upload";
            $data->file_url     = $path;
            $data->type = $request->embellishment_type;
            $data->save();
        }
    }
}
