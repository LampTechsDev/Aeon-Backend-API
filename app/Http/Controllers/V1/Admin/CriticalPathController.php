<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CriticalPathResource;
use App\Models\CriticalPath;
use App\Models\CriticalPathMasterFile;
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
    public function store(Request $request){
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
            $criticalPath->po_id=$request->po_id;
            $criticalPath->inspection_information_id=$request->inspection_information_id;
            $criticalPath->labdips_embellishment_id=$request->labdips_embellishment_id;
            $criticalPath->bulk_fabric_information_id =$request->bulk_fabric_information_id;
            $criticalPath->fabric_mill_id = $request->fabric_mill_id;
            $criticalPath->sample_approval_id=$request->sample_approval_id;
            $criticalPath->pp_meeting_id=$request->pp_meeting_id;
            $criticalPath->production_information_id=$request->production_information_id;
            //$criticalPath->production_information_id=$request->production_information_id;
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

            $this->saveFileInfo($request, $criticalPath);
            DB::commit();
            $this->apiSuccess();
            $this->data = (new CriticalPathResource($criticalPath));
            return $this->apiOutput("Critical Path Department Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

     //Save Additional File Info
     public function saveFileInfo($request,$criticalPath){
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
            $criticalPath->po_id=$request->po_id;
            $criticalPath->inspection_information_id=$request->inspection_information_id;
            $criticalPath->labdips_embellishment_id=$request->labdips_embellishment_id;
            $criticalPath->bulk_fabric_information_id =$request->bulk_fabric_information_id;
            $criticalPath->fabric_mill_id = $request->fabric_mill_id;
            $criticalPath->sample_approval_id=$request->sample_approval_id;
            $criticalPath->pp_meeting_id=$request->pp_meeting_id;
            $criticalPath->production_information_id=$request->production_information_id;
            $criticalPath->	lead_times=$request->lead_times;
            $criticalPath->lead_type=$request->lead_type;
            $criticalPath->	official_po_plan=$request->official_po_plan;
            $criticalPath->official_po_actual=$request->official_po_actual;
            $criticalPath->status=$request->status;
            $criticalPath->aeon_comments=$request->aeon_comments;
            $criticalPath->vendor_comments=$request->vendor_comments;
            $criticalPath->other_comments=$request->other_comments;
            $criticalPath->save();
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


}
