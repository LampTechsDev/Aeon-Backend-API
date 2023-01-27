<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BulkFabricInformationResource;
use App\Models\BulkFabricInformation;
use App\Models\BulkFabricKnitDownImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class BulkFabricInformationController extends Controller
{

    public function index()
    {
       try{
        //return 10;
            // if(!PermissionController::hasAccess("group_list")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }
            $this->data = BulkFabricInformationResource::collection(BulkFabricInformation::all());
            $this->apiSuccess("BulkFabricInformation Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request){
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
   
            $bulkFabricInformation = new BulkFabricInformation();
            $bulkFabricInformation->po_number = $request->po_number ;
            $bulkFabricInformation->po_id = $request->po_id;
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
            $this->saveFileInfo($request, $bulkFabricInformation );
            
            DB::commit();
            $this->apiSuccess();
            $this->data = (new BulkFabricInformationResource($bulkFabricInformation));
            return $this->apiOutput("BulkFabricInformation Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    //BulkFabric Save File Info
    public function saveFileInfo($request, $bulkFabricInformation){
        $file_path = $this->uploadFile($request, 'file', $this->labdips_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new BulkFabricKnitDownImage();
            $data->bulk_fabric_information_id = $bulkFabricInformation->id;
            $data->file_name    = $request->file_name ?? "BulkFabricKnitDownImage File Upload";
            $data->file_url     = $path;
            $data->type = $request->type;
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
          
   
            $bulkFabricInformation = BulkFabricInformation::find($request->id);
            $bulkFabricInformation->po_number = $request->po_number ;
            $bulkFabricInformation->po_id = $request->po_id;
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
            
            
            $this->apiSuccess();
            $this->data = (new BulkFabricInformationResource($bulkFabricInformation))->hide(["upload_files"]);
            return $this->apiOutput("BulkFabricInformation Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


         /*
        Show
        */
        public function show(Request $request)
        {
            try{
    
                $bulkFabricInformation = BulkFabricInformation::find($request->id);
                $this->data = (new  BulkFabricInformationResource($bulkFabricInformation));
                $this->apiSuccess("BulkFabricInformation Showed Successfully");
                return $this->apiOutput();
    
            }catch(Exception $e){
                return $this->apiOutput($this->getError($e), 500);
            }
        }


                /*
            Delete
            */
            public function delete(Request $request)
            {
                BulkFabricInformation::where("id", $request->id)->delete();
                $this->apiSuccess();
                return $this->apiOutput("BulkFabricInformation Deleted Successfully", 200);
            }


            public function updateBulkFileInfo(Request $request){
                try{
                    $validator = Validator::make( $request->all(),[
                        //"id"            => ["required", "exists:ticket_uploads,id"],
        
                    ]);
        
                    if ($validator->fails()) {
                        return $this->apiOutput($this->getValidationError($validator), 200);
                    }
        
                    $data = BulkFabricKnitDownImage::find($request->id);
                    
                    if($request->hasFile('picture')){
                        $data->file_url = $this->uploadFileNid($request, 'picture', $this->labdips_uploads, null,null,$data->file_url);
                    }
        
                    $data->save();
                  
                    $this->apiSuccess("BulkFabric File Updated Successfully");
                    return $this->apiOutput();
                   
                   
                }catch(Exception $e){
                    return $this->apiOutput($this->getError( $e), 500);
                }
            }

            //Additional BulkFabric Save File Info
            public function addBulkFabricFile(Request $request){
                try{
                    $validator = Validator::make( $request->all(),[
                        //"bulk_fabric_information_id"            => ["required","exists:lab_dips_embellishment_information,id"],

                    ]);

                    if ($validator->fails()) {
                        return $this->apiOutput($this->getValidationError($validator), 200);
                    }

                    $this->saveAdditionalBulkFabricFileInfo($request);
                    $this->apiSuccess("Embellishment File Added Successfully");
                    return $this->apiOutput();
                
                
                }catch(Exception $e){
                    return $this->apiOutput($this->getError( $e), 500);
                }
            }

        //BulkFabric Save File Info
        public function saveAdditionalBulkFabricFileInfo($request){
            $file_path = $this->uploadFileNid($request, 'file', $this->labdips_uploads, 720);

            if( !is_array($file_path) ){
                $file_path = (array) $file_path;
            }
            foreach($file_path as $path){
                $data = new BulkFabricKnitDownImage();
                $data->bulk_fabric_information_id = $request->bulk_fabric_information_id;
                $data->file_name    = $request->file_name ?? "BulkFabricKnitDownImage File Upload";
                $data->file_url     = $path;
                $data->type = $request->type;
                $data->save();
            }
        }


        public function deleteFileBulk(Request $request){
            try{
               
                $validator = Validator::make( $request->all(),[
                    //"id"            => ["required", "exists:ticket_uploads,id"],
                ]);
    
                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 200);
                }
        
                $data=BulkFabricKnitDownImage::where('id',$request->id);
                $data->delete();
                $this->apiSuccess("BulkFabricKnitDownImage Deleted successfully");
                return $this->apiOutput();
            }catch(Exception $e){
                return $this->apiOutput($this->getError( $e), 500);
            }
        }


}
