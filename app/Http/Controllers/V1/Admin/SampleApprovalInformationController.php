<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionSampleShippingResource;
use App\Http\Resources\SampleApprovalInformationResource;
use App\Models\FitSampleImage;
use App\Models\PhotoSample;
use App\Models\PpSampleImage;
use App\Models\SampleApprovalInformation;
use App\Models\SizeSetSampleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class SampleApprovalInformationController extends Controller
{
    public function index()
    {
       try{

            $this->data = ProductionSampleShippingResource::collection(SampleApprovalInformation::all());
            $this->apiSuccess("Sample Approval Information Loaded Successfully");
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

            $sampleApproval = new SampleApprovalInformation();
            $sampleApproval->po_id=$request->po_id;
            $sampleApproval->po_number=$request->po_number;
            $sampleApproval->development_photo_sample_sent_plan                  = $request->development_photo_sample_sent_plan;
            $sampleApproval->development_photo_sample_sent_plan_buyer            = $request->development_photo_sample_sent_plan_buyer;
            $sampleApproval->development_photo_sample_sent_actual                = $request->development_photo_sample_sent_actual;
            $sampleApproval->development_photo_sample_dispatch_details           = $request->development_photo_sample_dispatch_details;
            $sampleApproval->development_photo_sample_dispatch_sending_date      = $request->development_photo_sample_dispatch_sending_date;
            $sampleApproval->development_photo_sample_dispatch_awb_number        = $request->development_photo_sample_dispatch_awb_number;
            $sampleApproval->development_photo_sample_dispatch_review_meeting    = $request->development_photo_sample_dispatch_review_meeting;
            $sampleApproval->fit_sample_review_meeting                           = $request->fit_sample_review_meeting;
            $sampleApproval->size_set_sample_review_meeting                      = $request->size_set_sample_review_meeting;
            $sampleApproval->pp_sample_review_meeting                            = $request->pp_sample_review_meeting;
            $sampleApproval->fit_approval_plan                                   = $request->fit_approval_plan;
            $sampleApproval->fit_approval_plan_buyer                             = $request->fit_approval_plan_buyer;
            $sampleApproval->fit_approval_actual                                 = $request->fit_approval_actual;
            $sampleApproval->fit_sample_dispatch_details                         = $request->fit_sample_dispatch_details;
            $sampleApproval->fit_sample_dispatch_sending_date                    = $request->fit_sample_dispatch_sending_date;
            $sampleApproval->fit_sample_dispatch_aob_number                      = $request->fit_sample_dispatch_aob_number;
            $sampleApproval->size_set_approval_plan                              = $request->size_set_approval_plan;
            $sampleApproval->size_set_approval_plan_buyer                        = $request->size_set_approval_plan_buyer;
            $sampleApproval->size_set_approval_actual                            = $request->size_set_approval_actual;
            $sampleApproval->size_set_sample_dispatch_details                    = $request->size_set_sample_dispatch_details;
            $sampleApproval->size_set_sample_dispatch_sending_date               = $request->size_set_sample_dispatch_sending_date;
            $sampleApproval->size_set_sample_dispatch_aob_number                 = $request->size_set_sample_dispatch_aob_number;
            $sampleApproval->pp_approval_plan                                    = $request->pp_approval_plan;
            $sampleApproval->pp_approval_plan_buyer                              = $request->pp_approval_plan_buyer;
            $sampleApproval->pp_approval_actual                                  = $request->pp_approval_actual;
            $sampleApproval->pp_sample_dispatch_details                          = $request->pp_sample_dispatch_details;
            $sampleApproval->pp_sample_sending_date                              = $request->pp_sample_sending_date;
            $sampleApproval->pp_sample_courier_aob_number                        = $request->pp_sample_courier_aob_number;
            $sampleApproval->save();
            $this->savePhotoSampleFileInfo($request, $sampleApproval);
            $this->saveFitSampleFileInfo($request, $sampleApproval);
            $this->saveSizeSetSampleImageFileInfo($request, $sampleApproval);
            $this->savePpSampleImageFileInfo($request, $sampleApproval);

            DB::commit();
            $this->apiSuccess();
            $this->data = (new ProductionSampleShippingResource($sampleApproval));
            return $this->apiOutput("SampleApprovalInformation Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

      // Photo Sample Image File Info
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

    // Fit Sample Image File Info
    public function saveFitSampleFileInfo($request, $sampleApproval){
        $file_path = $this->uploadFile($request, 'fitsampleImageFile', $this->sampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new FitSampleImage();
            $data->sample_approval_id  = $sampleApproval->id;
            $data->file_name    = $request->file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->fit_sample_image_type;
            $data->save();
        }
    }

    // Size Set Sample Image File Info
    public function saveSizeSetSampleImageFileInfo($request, $sampleApproval){
        $file_path = $this->uploadFile($request, 'sizeSetsampleImageFile', $this->sizeSetsampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new SizeSetSampleImage();
            $data->sample_approval_id  = $sampleApproval->id;
            $data->file_name    = $request->file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->size_set_sample_image_type;
            $data->save();
        }
    }

    //Size PP Sample Image File Info
    public function savePpSampleImageFileInfo($request, $sampleApproval){
        $file_path = $this->uploadFile($request, 'ppsampleImageFile', $this->ppsampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PpSampleImage();
            $data->sample_approval_id  = $sampleApproval->id;
            $data->file_name    = $request->file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->pp_sample_image_type;
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

            $sampleApproval = SampleApprovalInformation::find($request->id);
            $sampleApproval->development_photo_sample_sent_plan                  = $request->development_photo_sample_sent_plan;
            $sampleApproval->development_photo_sample_sent_plan_buyer            = $request->development_photo_sample_sent_plan_buyer;
            $sampleApproval->development_photo_sample_sent_actual                = $request->development_photo_sample_sent_actual;
            $sampleApproval->development_photo_sample_dispatch_details           = $request->development_photo_sample_dispatch_details;
            $sampleApproval->development_photo_sample_dispatch_sending_date      = $request->development_photo_sample_dispatch_sending_date;
            $sampleApproval->development_photo_sample_dispatch_awb_number        = $request->development_photo_sample_dispatch_awb_number;
            $sampleApproval->development_photo_sample_dispatch_review_meeting    = $request->development_photo_sample_dispatch_review_meeting;
            $sampleApproval->fit_sample_review_meeting                           = $request->fit_sample_review_meeting;
            $sampleApproval->size_set_sample_review_meeting                      = $request->size_set_sample_review_meeting;
            $sampleApproval->pp_sample_review_meeting                            = $request->pp_sample_review_meeting;
            $sampleApproval->fit_approval_plan                                   = $request->fit_approval_plan;
            $sampleApproval->fit_approval_plan_buyer                             = $request->fit_approval_plan_buyer;
            $sampleApproval->fit_approval_actual                                 = $request->fit_approval_actual;
            $sampleApproval->fit_sample_dispatch_details                         = $request->fit_sample_dispatch_details;
            $sampleApproval->fit_sample_dispatch_sending_date                    = $request->fit_sample_dispatch_sending_date;
            $sampleApproval->fit_sample_dispatch_aob_number                      = $request->fit_sample_dispatch_aob_number;
            $sampleApproval->size_set_approval_plan                              = $request->size_set_approval_plan;
            $sampleApproval->size_set_approval_plan_buyer                        = $request->size_set_approval_plan_buyer;
            $sampleApproval->size_set_approval_actual                            = $request->size_set_approval_actual;
            $sampleApproval->size_set_sample_dispatch_details                    = $request->size_set_sample_dispatch_details;
            $sampleApproval->size_set_sample_dispatch_sending_date               = $request->size_set_sample_dispatch_sending_date;
            $sampleApproval->size_set_sample_dispatch_aob_number                 = $request->size_set_sample_dispatch_aob_number;
            $sampleApproval->pp_approval_plan                                    = $request->pp_approval_plan;
            $sampleApproval->pp_approval_plan_buyer                              = $request->pp_approval_plan_buyer;
            $sampleApproval->pp_approval_actual                                  = $request->pp_approval_actual;
            $sampleApproval->pp_sample_dispatch_details                          = $request->pp_sample_dispatch_details;
            $sampleApproval->pp_sample_sending_date                              = $request->pp_sample_sending_date;
            $sampleApproval->pp_sample_courier_aob_number                        = $request->pp_sample_courier_aob_number;
            $sampleApproval->save();
            $this->apiSuccess();
            $this->data = (new ProductionSampleShippingResource($sampleApproval))->hide(["photo_sample_image","fit_sample_image","size_set_sample_image", "pp_sample_image"]);
            return $this->apiOutput("SampleApprovalInformation Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{

            $sampleApproval =  SampleApprovalInformation::find($request->id);
            $this->data = (new ProductionSampleShippingResource($sampleApproval));
            $this->apiSuccess("Sample Approval Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function delete(Request $request)
    {
        SampleApprovalInformation::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Sample Approval Information Deleted Successfully", 200);
    }


    public function updatePhotoSampleFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = PhotoSample::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->sampleImage_uploads, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("Photo Sample File Updated Successfully");
            return $this->apiOutput();


        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function updateFitSampleFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = FitSampleImage::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->sampleImage_uploads, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("Fit Sample File Updated Successfully");
            return $this->apiOutput();


        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function updateSizeSetSampleFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = SizeSetSampleImage::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->sampleImage_uploads, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("SizeSetSample File Updated Successfully");
            return $this->apiOutput();


        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function updatePpSampleImageFileInfo(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //"id"            => ["required", "exists:ticket_uploads,id"],

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 200);
            }

            $data = PpSampleImage::find($request->id);

            if($request->hasFile('picture')){
                $data->file_url = $this->uploadFileNid($request, 'picture', $this->sampleImage_uploads, null,null,$data->file_url);
            }

            $data->save();

            $this->apiSuccess("PpSampleImage File Updated Successfully");
            return $this->apiOutput();


        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    // Additional Photo Sample Image File Info
    public function saveAdditionalPhotoSampleFileInfo($request){
        $file_path = $this->uploadFile($request, 'photosampleImageFile', $this->sampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PhotoSample();
            $data->sample_approval_id  = $request->sample_approval_id;
            $data->file_name    = $request->photo_sample_file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->photo_sample_image_type;
            $data->save();
        }
    }

    // Additional Fit Sample Image File Info
    public function saveAdditionalFitSampleFileInfo($request){
        $file_path = $this->uploadFile($request, 'fitsampleImageFile', $this->sampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new FitSampleImage();
            $data->sample_approval_id  = $request->sample_approval_id;
            $data->file_name    = $request->file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->fit_sample_image_type;
            $data->save();
        }
    }

    // Size Set Sample Image File Info
    public function saveAdditionalSizeSetSampleImageFileInfo($request){
        $file_path = $this->uploadFile($request, 'sizeSetsampleImageFile', $this->sizeSetsampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new SizeSetSampleImage();
            $data->sample_approval_id  = $request->sample_approval_id;
            $data->file_name    = $request->file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->size_set_sample_image_type;
            $data->save();
        }
    }

    //Additional PP Sample Image File Info
    public function saveAdditionalPpSampleImageFileInfo($request){
        $file_path = $this->uploadFile($request, 'ppsampleImageFile', $this->ppsampleImage_uploads, 720);

        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PpSampleImage();
            $data->sample_approval_id  = $request->sample_approval_id;
            $data->file_name    = $request->file_name ?? "Sample_Approval Upload";
            $data->file_url     = $path;
            $data->type = $request->pp_sample_image_type;
            $data->save();
        }
    }

    //Additional PhotoSample Save File Info
    public function addPhotoSampleFile(Request $request){
        try{
                $validator = Validator::make( $request->all(),[
                        //"bulk_fabric_information_id"            => ["required","exists:lab_dips_embellishment_information,id"],

                ]);

                    if ($validator->fails()) {
                        return $this->apiOutput($this->getValidationError($validator), 200);
                    }

                    $this->saveAdditionalPhotoSampleFileInfo($request);
                    $this->apiSuccess("Additional Photo Sample File Added Successfully");
                    return $this->apiOutput();


                }catch(Exception $e){
                    return $this->apiOutput($this->getError( $e), 500);
                }
            }

    //Additional FitSample Save File Info
    public function addFitSampleFile(Request $request){
        try{
                $validator = Validator::make( $request->all(),[
                        //"bulk_fabric_information_id"            => ["required","exists:lab_dips_embellishment_information,id"],

                ]);

                    if ($validator->fails()) {
                        return $this->apiOutput($this->getValidationError($validator), 200);
                    }

                    $this->saveAdditionalFitSampleFileInfo($request);
                    $this->apiSuccess("Bulk Fabric File Added Successfully");
                    return $this->apiOutput();


                }catch(Exception $e){
                    return $this->apiOutput($this->getError( $e), 500);
                }
            }

    //Additional SetSampleImage Save File Info
    public function addSizeSetSampleImageFile(Request $request){
        try{
                $validator = Validator::make( $request->all(),[
                        //"bulk_fabric_information_id"            => ["required","exists:lab_dips_embellishment_information,id"],

                ]);

                    if ($validator->fails()) {
                        return $this->apiOutput($this->getValidationError($validator), 200);
                    }

                    $this->saveAdditionalSizeSetSampleImageFileInfo($request);
                    $this->apiSuccess("SizeSetSampleImage File Added Successfully");
                    return $this->apiOutput();


                }catch(Exception $e){
                    return $this->apiOutput($this->getError( $e), 500);
                }
        }

        //Additional BulkFabric Save File Info
         public function addAdditionalPpSampleImageFile(Request $request){
                try{
                    $validator = Validator::make( $request->all(),[
                            //"bulk_fabric_information_id"            => ["required","exists:lab_dips_embellishment_information,id"],

                    ]);

                    if ($validator->fails()) {
                        return $this->apiOutput($this->getValidationError($validator), 200);
                    }

                    $this->saveAdditionalPpSampleImageFileInfo($request);
                    $this->apiSuccess("Additional PpSampleImage File Added Successfully");
                    return $this->apiOutput();


                }catch(Exception $e){
                    return $this->apiOutput($this->getError( $e), 500);
                }
            }


}
