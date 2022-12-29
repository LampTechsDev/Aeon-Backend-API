<?php

namespace App\Http\Components\Traits;

/**
 *
 * @author Sm Shahjalal Shaju
 */

use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


trait Upload{
    /*
     * Define Directories
     */
    protected  $patient_uploads = "storage/uploads/patient/";
    protected  $nid_patient_uploads = "storage/uploads/nidpicture/";
    protected  $therapist_uploads = "storage/uploads/therapist/";
    protected  $appointment_uploads = "storage/uploads/appointment/";
    protected  $ticket_uploads = "storage/uploads/ticket/";
    protected  $compliance_uploads = "storage/uploads/compliance/";
    protected  $pogarments_uploads = "storage/uploads/pogarments/";
    protected  $poartworks_uploads = "storage/uploads/poartworks/";
    protected  $admin_profile = "storage/uploads/admin/profile";
    protected  $logo_dir = "storage/uploads/logo";
    protected  $others_dir = "storage/uploads/others";
    protected  $vendor_logo = "storage/uploads/vendor";
    protected  $vendor_profile_logo = "storage/uploads/vendorprofile";
    protected  $vendor_profile_attach_file_upload = "storage/uploads/vendorprofileattachfileupload";
    protected  $customer_logo = "storage/uploads/customer";
    protected  $customer_department_image = "storage/uploads/customerdepartmentimage";
    protected  $global_certificate_logo = "storage/uploads/globalcertificate";
    protected  $vendor_certificate_logo = "storage/uploads/vendorcertificate";
    protected  $vendor_certificate_attachment = "storage/uploads/vendorattachment";
    protected  $vendor_manufacturer_logo = "storage/uploads/vendormanufacturer";
    protected  $manufacturer_profile_logo = "storage/uploads/manufacturerprofile";
    protected  $manufacturer_certificate_attachment = "storage/uploads/manufacturercertificate";

    /*
     * ---------------------------------------------
     * Check the Derectory If exists or Not
     * ---------------------------------------------
     */
    protected function CheckDir($dir){
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }

        if(!file_exists($dir.'index.php')){
            $file = fopen($dir.'index.php','w');
            fwrite($file," <?php \n /* \n Unauthorize Access \n @Developer: Sm Shahjalal Shaju \n Email: shajushahjalal@gmail.com \n */ ");
            fclose($file);
        }
    }

    /*
     * ---------------------------------------------
     * Check the file If exists then Delete the file
     * ---------------------------------------------
     */
    protected function RemoveFile($filePath) {
        if(file_exists($filePath)){
            try{
                unlink($filePath);
            }catch(Exception $e){
                // Exception
            }
        }
    }

    /*
     * ---------------------------------------------
     * Upload an Image
     * Change Image height and width
     * Send the null value in height or width to keep
     * the Image Orginal Ratio.
     * ---------------------------------------------
     */
    protected function uploadFile($request, $fileName, $dir, $width = null, $height =  null, $oldFile = ""){
        if(!$request->hasFile($fileName)){
            return $oldFile;
        }
        $this->CheckDir($dir);
        $this->RemoveFile($oldFile);

        ini_set('memory_limit', '1024M');
        $path_arr = [];

        if(is_array($request->$fileName) ){
            foreach($request->$fileName as $key => $file){
                $file = $request->file($fileName)[$key];
                $filename = $fileName.'_'.time().$key.'.'.$file->getClientOriginalExtension();
                $path = $dir.$filename;

                if( $this->isImage($path) ){
                    if( empty($height) && empty($width)){
                        Image::make($file)->save($path);
                    }
                    elseif( empty($height) && !empty($width) ){
                        Image::make($file)->resize($width,null,function($constant){
                            $constant->aspectRatio();
                        })->save($path);
                    }
                    elseif( !empty($height) && empty($width) ){
                        Image::make($file)->resize(null,$height,function($constant){
                            $constant->aspectRatio();
                        })->save($path);
                    }
                    else{
                        Image::make($file)->resize($width,$height)->save($path);
                    }
                }else{
                    $_dir = trim(str_replace("storage/", "", $dir), "/");
                    $path = "storage/".Storage::disk("public")->putFile($_dir, $file);
                }
                $path_arr[] = $path;
            }
        }else{
            $image = $request->file($fileName);
            $filename = $fileName.'_'.time().'.'.$image->getClientOriginalExtension();
            $path = $dir.$filename;

            if( empty($height) && empty($width)){
                Image::make($image)->save($path);
            }
            elseif( empty($height) && !empty($width) ){
                Image::make($image)->resize($width,null,function($constant){
                    $constant->aspectRatio();
                })->save($path);
            }
            elseif( !empty($height) && empty($width) ){
                Image::make($image)->resize(null,$height,function($constant){
                    $constant->aspectRatio();
                })->save($path);
            }
            else{
                Image::make($image)->resize($width,$height)->save($path);
            }
            $path_arr   = $path;
        }
        return $path_arr;
    }

    //upload image nid
    protected function uploadFileNid($request, $fileName, $dir, $width = null, $height =  null, $oldFile = ""){
        if(!$request->hasFile($fileName)){
            return $oldFile;
        }
        $this->CheckDir($dir);
        $this->RemoveFile($oldFile);

        ini_set('memory_limit', '1024M');
        $path_arr = [];

        if(is_array($request->$fileName) ){
            foreach($request->$fileName as $key => $file){
                $image = $request->file($fileName)[$key];
                $filename = $fileName.'_'.time().$key.'.'.$image->getClientOriginalExtension();
                $path = $dir.$filename;

                if( empty($height) && empty($width)){
                    Image::make($image)->save($path);
                }
                elseif( empty($height) && !empty($width) ){
                    Image::make($image)->resize($width,null,function($constant){
                        $constant->aspectRatio();
                    })->save($path);
                }
                elseif( !empty($height) && empty($width) ){
                    Image::make($image)->resize(null,$height,function($constant){
                        $constant->aspectRatio();
                    })->save($path);
                }
                else{
                    Image::make($image)->resize($width,$height)->save($path);
                }
                $path_arr[] = $path;
            }
        }else{
            $image = $request->file($fileName);
            $filename = $fileName.'_'.time().'.'.$image->getClientOriginalExtension();
            $path = $dir.$filename;

            if( empty($height) && empty($width)){
                Image::make($image)->save($path);
            }
            elseif( empty($height) && !empty($width) ){
                Image::make($image)->resize($width,null,function($constant){
                    $constant->aspectRatio();
                })->save($path);
            }
            elseif( !empty($height) && empty($width) ){
                Image::make($image)->resize(null,$height,function($constant){
                    $constant->aspectRatio();
                })->save($path);
            }
            else{
                Image::make($image)->resize($width,$height)->save($path);
            }
            $path_arr   = $path;
        }
        return $path_arr;
    }

    /**
     * Check Image or not
     * @return boolean
     */
    function isImage($file_path){
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);
        $imgExtArr = ['jpg', 'jpeg', 'png'];
        if(in_array($extension, $imgExtArr)){
            return true;
        }
        return false;
    }

    /*
     * ---------------------------------------------
     * Upload any Kind of file
     * ---------------------------------------------
     */
    protected function UploadAnyFile($request, $fileName, $dir, $oldFile){
        if(!$request->hasFile($fileName)){
            return $oldFile;
        }
        ini_set('memory_limit', '1024M');
        $this->CheckDir($dir);
        $this->RemoveFile($oldFile);
        $file = $request->file($fileName);
        $new_file_name = 'file_'.time().'.'.$file->getClientOriginalExtension();
        $file->move($dir,$new_file_name);
        return $dir.$new_file_name;
    }
}
