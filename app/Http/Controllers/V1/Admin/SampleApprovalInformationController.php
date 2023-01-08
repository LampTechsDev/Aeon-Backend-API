<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SampleApprovalInformationResource;
use App\Models\PhotoSample;
use App\Models\SampleApprovalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;


class SampleApprovalInformationController extends Controller
{
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
   
            $sampleApproval = new SampleApprovalInformation();
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
            $this->savePhotoSampleFileInfo($request, $sampleApproval);
            $this->apiSuccess();
            $this->data = (new SampleApprovalInformationResource($sampleApproval));
            return $this->apiOutput("SampleApprovalInformation Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

      // Save File Info
      public function savePhotoSampleFileInfo($request, $sampleApproval){
        $file_path = $this->uploadFile($request, 'photosampleImageFile', $this->sampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PhotoSample();
            $data->sample_approval_id  = $sampleApproval->id;
            $data->file_name    = $request->photo_sample_file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->photo_sample_image_type;
            $data->save();
        }
    }
}
