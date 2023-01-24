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
use Illuminate\Support\Facades\DB;

class LabDipsEmbellishmentInformationController extends Controller
{

    public function index(){
        try{
                
            $this->data = LabDipsEmbellishmentInformationResource::collection(LabDipsEmbellishmentInformation::all());
            $this->apiSuccess("LabDipsEmbellishmentInformation List Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request)
    {
     
        try{

            // if(!PermissionController::hasAccess("group_create")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

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

            DB::commit();
            $this->apiSuccess();
            $this->data = (new LabDipsEmbellishmentInformationResource($labDips));
            return $this->apiOutput("LabDips and Emabellishment Information Added Successfully");
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

    public function update(Request $request){
        try{

            // if(!PermissionController::hasAccess("group_create")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $labDips = LabDipsEmbellishmentInformation::find($request->id);
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
            $this->data = (new LabDipsEmbellishmentInformationResource($labDips))->hide(["labDips_upload_file","embellishment_so_image"]);
            return $this->apiOutput("LabDips and Emabellishment Information Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
           
            $labDips = LabDipsEmbellishmentInformation::find($request->id);
            $this->data = (new LabDipsEmbellishmentInformationResource($labDips));
            $this->apiSuccess("LabdipsEmbellishmentInformation Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function delete(Request $request)
    {
        LabDipsEmbellishmentInformation::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("LabdipsEmbellishmentInformation  Deleted Successfully", 200);
    }

    public function updateLabDipFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = LabDipImage::find($request->id);
            
            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->labdips_uploads, null,null,$data->file_url);
            }

            $data->save();
          
            $this->apiSuccess("LabDip File Updated Successfully");
            return $this->apiOutput();
           
           
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function updateEmbellishmentFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = EmbellishmentImage::find($request->id);
            
            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->labdips_uploads, null,null,$data->file_url);
            }

            $data->save();
          
            $this->apiSuccess("EmbellishmentFile File Updated Successfully");
            return $this->apiOutput();
           
           
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

     //Additional LabDip Save File Info
    public function addFileLabDip(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                "labdips_embellishment_id"            => ["required","exists:lab_dips_embellishment_information,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $this->saveAdditonalLabDipFileInfo($request);
            $this->apiSuccess("LabDip File Added Successfully");
            return $this->apiOutput();
           
           
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    //Additional LabDip Save File Info
    public function saveAdditonalLabDipFileInfo($request){
        $file_path = $this->uploadFile($request, 'labDipsfile', $this->labdips_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new LabDipImage();
            $data->labdips_embellishment_id = $request->labdips_embellishment_id;
            $data->file_name    = $request->lab_dip_file_name ?? "LabDipImage File Upload";
            $data->file_url     = $path;
            $data->type = $request->lab_dip_file_type;
            $data->save();
        }
    }


    
     //Additional Embellish Save File Info
     public function addFileEmbellish(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                "labdips_embellishment_id"            => ["required","exists:lab_dips_embellishment_information,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $this->saveAdditionalEmbellishmentFileInfo($request);
            $this->apiSuccess("Embellishment File Added Successfully");
            return $this->apiOutput();
           
           
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    //Embellishment Save File Info
    public function saveAdditionalEmbellishmentFileInfo($request){
        $file_path = $this->uploadFile($request, 'embellishmentfile', $this->labdips_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new EmbellishmentImage();
            $data->labdips_embellishment_id = $request->labdips_embellishment_id;
            $data->file_name    = $request->embellishment_file_name ?? "EmbellishmentImage File Upload";
            $data->file_url     = $path;
            $data->type = $request->embellishment_type;
            $data->save();
        }
    }
}

