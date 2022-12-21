<?php

namespace App\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use App\Models\GlobalCertificate;
use App\Http\Controllers\Controller;
use App\Http\Resources\GlobalCertificateResource;
use Exception;
use Illuminate\Support\Facades\Validator;

class GlobalCertificateController extends Controller
{

/**
* Show Login
*/
public function showLogin(Request $request){
    $this->data = [
        "email"     => "required",
        "password"  => "required",
    ];
    $this->apiSuccess("This credentials are required for Login ");
    return $this->apiOutput(200);
  }


  public function index()
  {
    try{
        $this->data = GlobalCertificateResource::collection(GlobalCertificate::all());
        $this->apiSuccess(" Global Certificate Load has been Successfully done");
        return $this->apiOutput();

    }catch(Exception $e){
        return $this->apiOutput($this->getError($e), 500);
    }
  }

  public function show(Request $request)
  {
    try{
        $global_certificate = GlobalCertificate::find($request->id);
        if( empty($global_certificate) ){
            return $this->apiOutput("Customer Department Data Not Found", 400);
        }
        $this->data = (new GlobalCertificateResource ($global_certificate));
        $this->apiSuccess(" Global Certificate Detail Show Successfully");
        return $this->apiOutput();
    }catch(Exception $e){
        return $this->apiOutput($this->getError($e), 500);
    }
  }

  public function store(Request $request)
  {

    try{
        $validator = Validator::make(
            $request->all(),
            [
                "name"                      => ["required"],
                "status"                    => 'required',

            ],[
                // "group_id.exists"     => "No Record found under this group",
            ]
           );

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 400);
            }
            $global_certificate = new GlobalCertificate();

            $global_certificate->name                  = $request->name;
            $global_certificate->logo                  = $this->uploadFile($request, 'logo', $this->global_certificate_logo, 720);
            $global_certificate->details               = $request->details;


            $global_certificate->remarks               = $request->remarks;
            $global_certificate->status                = $request->status;
         //    $customer->created_by = $request->created_by;
         //    $customer->updated_by = $request->updated_by;
            $global_certificate->created_at            = $request->created_at;
            $global_certificate->updated_at            = $request->updated_at;
            $global_certificate->deleted_by            = $request->deleted_by;
            $global_certificate->deleted_date          = $request->deleted_date;

            $global_certificate->save();

        try{
            event(new GlobalCertificateResource($global_certificate));
        }catch(Exception $e){

        }
        $this->apiSuccess(" Global Certificate Added Successfully");
        $this->data = (new GlobalCertificateResource($global_certificate));
        return $this->apiOutput();

    }catch(Exception $e){
        return $this->apiOutput($this->getError( $e), 500);
    }
  }

  public function update(Request $request,$id)
  {
    try{
    $validator = Validator::make($request->all(),[
      "name"                      => ["required"],
      "status"                    => 'required',
    ],[
        // "id"                  => "No Data Found for this Id",
        // "group_id.exists"     => "No Record found under this group",
    ]
    );

       if ($validator->fails()) {
        $this->apiOutput($this->getValidationError($validator), 400);
       }

        $global_certificate = GlobalCertificate::find($request->id);
        // if(empty($admin)){
        //     return $this->apiOutput("No Data Found", $admin);
        // }

        $global_certificate->name                  = $request->name;
        $global_certificate->logo                  = $this->uploadFile($request, 'logo', $this->global_certificate_logo, 720);
        $global_certificate->details               = $request->details;


        $global_certificate->remarks               = $request->remarks;
        $global_certificate->status                = $request->status;
     //    $customer->created_by = $request->created_by;
     //    $customer->updated_by = $request->updated_by;
        $global_certificate->created_at            = $request->created_at;
        $global_certificate->updated_at            = $request->updated_at;
        $global_certificate->deleted_by            = $request->deleted_by;
        $global_certificate->deleted_date          = $request->deleted_date;

        $global_certificate->save();

        $this->apiSuccess(" Global Certificate Updated Successfully");

        $this->data = (new GlobalCertificateResource($global_certificate));
        return $this->apiOutput();
    }catch(Exception $e){
        return $this->apiOutput($this->getError( $e), 500);
    }
  }

  public function destroy(Request $request,$id)
  {
    $global_certificate = GlobalCertificate::find($request->id);
    $global_certificate->delete();
    $this->apiSuccess();
    return $this->apiOutput(" Global Certificate Deleted Successfully", 200);
  }

}
