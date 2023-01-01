<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ManufacturerContactPeople;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ManufacturerContactPeopleResource;

class ManufacturerContactPeopleController extends Controller
{
    public function index()
    {
        try{
            $this->data = ManufacturerContactPeopleResource::collection(ManufacturerContactPeople::all());
            $this->apiSuccess("Manufacturer Contact People Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $manufacturer =ManufacturerContactPeople::find($request->id);
            if( empty($manufacturer) ){
                return $this->apiOutput("Manufacturer Contact People Data Not Found", 400);
            }
            $this->data = (new ManufacturerContactPeopleResource($manufacturer));
            $this->apiSuccess("Manufacturer Contact People Detail Show Successfully");
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
                "vendor_id"            => ["required"],
                "employee_id"          => ["required"],
                "email"                => ["required","email"],
                "status"               => 'required',

            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

            $manufacturer_contact_people = new ManufacturerContactPeople();
            $manufacturer_contact_people->vendor_id              = $request->vendor_id;
            $manufacturer_contact_people->vendor_manufacturer_id = $request->vendor_manufacturer_id;
            $manufacturer_contact_people->employee_id            = $request->employee_id;
            $manufacturer_contact_people->first_name             = $request->first_name;
            $manufacturer_contact_people->last_name              = $request->last_name;
            $manufacturer_contact_people->designation            = $request->designation;
            $manufacturer_contact_people->department             = $request->department;
            $manufacturer_contact_people->category               = $request->category;
            $manufacturer_contact_people->phone                  = $request->phone;
            $manufacturer_contact_people->email                  = $request->email;
            $manufacturer_contact_people->remarks                = $request->remarks;
            $manufacturer_contact_people->status                 = $request->status;
            $manufacturer_contact_people->created_at             = $request->created_at;
            $manufacturer_contact_people->updated_at             = $request->updated_at;
            $manufacturer_contact_people->deleted_by             = $request->deleted_by;
            $manufacturer_contact_people->deleted_date           = $request->deleted_date;
            $manufacturer_contact_people->save();
            DB::commit();

            $this->apiSuccess("Manufacturer Contact People Added Successfully");
            $this->data = (new ManufacturerContactPeopleResource($manufacturer_contact_people));
            return $this->apiOutput();

        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
            "id"                   => ["required"],
            "vendor_id"            => ["required"],
            "employee_id"          => ["required"],
            "email"                => ["required","email"],
            "status"               => 'required',
            ] );

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

            $manufacturer_contact_people = ManufacturerContactPeople::find($request->id);
            $manufacturer_contact_people->vendor_id              = $request->vendor_id;
            $manufacturer_contact_people->vendor_manufacturer_id = $request->vendor_manufacturer_id ;
            $manufacturer_contact_people->employee_id            = $request->employee_id;
            $manufacturer_contact_people->first_name             = $request->first_name;
            $manufacturer_contact_people->last_name              = $request->last_name;
            $manufacturer_contact_people->designation            = $request->designation;
            $manufacturer_contact_people->department             = $request->department;
            $manufacturer_contact_people->category               = $request->category;
            $manufacturer_contact_people->phone                  = $request->phone;
            $manufacturer_contact_people->email                  = $request->email;
            $manufacturer_contact_people->remarks                = $request->remarks;
            $manufacturer_contact_people->status                 = $request->status;
            $manufacturer_contact_people->created_at             = $request->created_at;
            $manufacturer_contact_people->updated_at             = $request->updated_at;
            $manufacturer_contact_people->deleted_by             = $request->deleted_by;
            $manufacturer_contact_people->deleted_date           = $request->deleted_date;
            $manufacturer_contact_people->save();
            DB::commit();

            $this->apiSuccess("Manufacturer Contact People Updated Successfully");
            $this->data = (new ManufacturerContactPeopleResource($manufacturer_contact_people));
            return $this->apiOutput();
        }catch(Exception $e){
            DB::rollBack();
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    /*
       Delete
    */
    public function delete(Request $request)
    {
        ManufacturerContactPeople::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Manufacturer Contact People Deleted Successfully", 200);
    }


}
