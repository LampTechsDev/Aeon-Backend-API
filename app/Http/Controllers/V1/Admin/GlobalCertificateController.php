<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\GlobalCertificate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\GlobalCertificateResource;

class GlobalCertificateController extends Controller
{
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

    /**
    * Store Section
    **/

  public function store(Request $request)
  {

    try{
        $validator = Validator::make(
        $request->all(),
        ["name"                      => ["required"],
            "status"                    => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiOutput($this->getValidationError($validator), 400);
        }
        DB::beginTransaction();
        $global_certificate = new GlobalCertificate();
        $global_certificate->name                  = $request->name;
        $global_certificate->logo                  = $this->uploadFile($request, 'logo', $this->global_certificate_logo, 720);
        $global_certificate->details               = $request->details;
        $global_certificate->remarks               = $request->remarks;
        $global_certificate->status                = $request->status;

        $global_certificate->created_at            = $request->created_at;
        $global_certificate->updated_at            = $request->updated_at;
        $global_certificate->deleted_by            = $request->deleted_by;
        $global_certificate->deleted_date          = $request->deleted_date;
        $global_certificate->save();
        DB::commit();

        $this->apiSuccess(" Global Certificate Added Successfully");
        $this->data = (new GlobalCertificateResource($global_certificate));
        return $this->apiOutput();
    }catch(Exception $e){
        DB::rollBack();
        return $this->apiOutput($this->getError( $e), 500);
    }
  }

    /**
    * Update Section
    **/

  public function update(Request $request)
  {
    try{
    $validator = Validator::make($request->all(),[
      "name"                      => ["required"],
      "status"                    => 'required',
    ]);
       if ($validator->fails()) {
        $this->apiOutput($this->getValidationError($validator), 400);
       }
        DB::beginTransaction();
        $global_certificate = GlobalCertificate::find($request->id);
        $global_certificate->name                  = $request->name;
        $global_certificate->logo                  = $this->uploadFile($request, 'logo', $this->global_certificate_logo, 720);
        $global_certificate->details               = $request->details;

        $global_certificate->remarks               = $request->remarks;
        $global_certificate->status                = $request->status;
        $global_certificate->created_at            = $request->created_at;
        $global_certificate->updated_at            = $request->updated_at;
        $global_certificate->deleted_by            = $request->deleted_by;
        $global_certificate->deleted_date          = $request->deleted_date;
        $global_certificate->save();
        DB::commit();

        $this->apiSuccess(" Global Certificate Updated Successfully");
        $this->data = (new GlobalCertificateResource($global_certificate));
        return $this->apiOutput();
    }catch(Exception $e){
        DB::rollBack();
        return $this->apiOutput($this->getError( $e), 500);
    }
  }
    /**
    * Delete Section
    **/
    public function delete(Request $request)
    {
        GlobalCertificate::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Global Certificate Deleted Successfully", 200);
    }

}
