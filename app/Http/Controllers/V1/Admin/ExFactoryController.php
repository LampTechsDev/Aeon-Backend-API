<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExFactoryResource;
use App\Models\ExFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;

class ExFactoryController extends Controller
{
    public function store(Request $request){

        try{
            $validator = Validator::make( 
                $request->all(),
                 [
                    // "buyer_id"          => "required",
                    // "vendor_id"         => "required",
                    // "supplier_id"       => "required",
                    // "manufacturer_id"   => "required",
                ]
                
            );

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();

            $exfactory = new ExFactory();
            $exfactory->po_number = $request->po_number;
            $exfactory->po_id=$request->po_id;
            $exfactory->ex_factory_date_po=$request->ex_factory_date_po;
            $exfactory->revised_ex_factory_date=$request->revised_ex_factory_date;
            $exfactory->actual_ex_factory_date=$request->actual_ex_factory_date;
            $exfactory->shipped_units=$request->shipped_units;
            $exfactory->original_eta_sa_date=$request->original_eta_sa_date;
            $exfactory->revised_eta_sa_date=$request->revised_eta_sa_date;
            $exfactory->forwarded_ref_vessel_name=$request->forwarded_ref_vessel_name;
            $exfactory->save();
            DB::commit();
            $this->apiSuccess();
            $this->data = (new ExFactoryResource($exfactory));
            return $this->apiOutput("ExFactory Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
