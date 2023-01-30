<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\VendorManufacturer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\VendorManufacturerResource;
use Illuminate\Support\Facades\Validator;

class VendorManufacturerController extends Controller
{

    public function index()
    {
        try{
            $this->data = VendorManufacturerResource::collection(VendorManufacturer::all());
            $this->apiSuccess(" Vendor Manufacturer Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $manufacturer = VendorManufacturer::find($request->id);
            if( empty($manufacturer) ){
                return $this->apiOutput("Vendor Manufacturer Data Not Found", 400);
            }
            $this->data = (new VendorManufacturerResource ($manufacturer));
            $this->apiSuccess("Vendor Manufacturer Detail Show Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request)
    {

        try{

            DB::beginTransaction();

            $validator =Validator::make(
                $request->all(),
                [
                    "vendor_id"                    => ["required"],
                    "name"                         => ["required"],
                    "status"                       => 'required',

                ],[
                    // "group_id.exists"     => "No Record found under this group",
                ]
               );

                if ($validator->fails()) {
                    return $this->apiOutput($this->getValidationError($validator), 400);
                }
                $manufacturer = new VendorManufacturer();

                $manufacturer->vendor_id                = $request->vendor_id;
                $manufacturer->name                     = $request->name;
                $manufacturer->logo                     = $this->uploadFileNid($request, 'logo', $this->vendor_manufacturer_logo, 720);
                $manufacturer->phone                    = $request->phone;
                $manufacturer->email                    = $request->email;
                $manufacturer->address                  = $request->address;

                $manufacturer->remarks                  = $request->remarks;
                $manufacturer->status                   = $request->status;
                $manufacturer->created_at               = $request->created_at;
                $manufacturer->updated_at               = $request->updated_at;
                $manufacturer->deleted_by               = $request->deleted_by;
                $manufacturer->deleted_date             = $request->deleted_date;

                $manufacturer->save();

            try{
                event(new VendorManufacturerResource($manufacturer));
            }catch(Exception $e){

            }
            DB::commit();
            $this->apiSuccess("Vendor Manufacturer Added Successfully");
            $this->data = (new VendorManufacturerResource($manufacturer));
            return $this->apiOutput();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request,$id)
    {
        try{
            DB::beginTransaction();
        $validator = Validator::make($request->all(),[
            "vendor_id"                    => ["required"],
            "name"                         => ["required"],
            "status"                       => 'required',
        ],[
            // "id"                  => "No Data Found for this Id",
            // "group_id.exists"     => "No Record found under this group",
        ]
        );

           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $manufacturer = VendorManufacturer::find($request->id);

            $manufacturer->vendor_id                = $request->vendor_id;
            $manufacturer->name                     = $request->name;
            $manufacturer->logo                     = $this->uploadFileNid($request, 'logo', $this->vendor_manufacturer_logo, 720);
            $manufacturer->phone                    = $request->phone;
            $manufacturer->email                    = $request->email;
            $manufacturer->address                  = $request->address;

            $manufacturer->remarks                  = $request->remarks;
            $manufacturer->status                   = $request->status;
            $manufacturer->created_at               = $request->created_at;
            $manufacturer->updated_at               = $request->updated_at;
            $manufacturer->deleted_by               = $request->deleted_by;
            $manufacturer->deleted_date             = $request->deleted_date;

            $manufacturer->save();

            $this->apiSuccess("Vendor Manufacturer Updated Successfully");
            $this->data = (new VendorManufacturerResource($manufacturer));
            return $this->apiOutput();
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function destroy(Request $request,$id)
    {
        $certificate = VendorManufacturer::find($request->id);
        $certificate->delete();
        $this->apiSuccess();
        return $this->apiOutput("Vendor Manufacturer Deleted Successfully", 200);
    }


}
