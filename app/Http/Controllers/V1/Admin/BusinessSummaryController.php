<?php

namespace App\Http\Controllers\V1\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\BusinessSummary;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BusinessSummaryResource;

class BusinessSummaryController extends Controller
{
    public function index()
    {
        try{
            $this->data = BusinessSummaryResource::collection(BusinessSummary::all());
            $this->apiSuccess("Business Summary Load has been Successfully done");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            $business_summary = BusinessSummary::find($request->id);
            if( empty($business_summary) ){
                return $this->apiOutput("Business Summary Data Not Found", 400);
            }
            $this->data = (new BusinessSummaryResource($business_summary));
            $this->apiSuccess("Business Summary Detail Show Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /*
       Update
    */

    public function update(Request $request)
    {
        try{
        $validator = Validator::make($request->all(),[
            "po_id"                     => ["required"],
            "final_total_ship_qty"      => ["required"],
        ]);
           if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
           }

            $business_summary = BusinessSummary::find($request->id);

            $business_summary->po_id                     = $request->po_id ;
            $business_summary->final_total_ship_qty      = $request->final_total_ship_qty ;
            $business_summary->final_total_invoice_value = $request->final_total_invoice_value ;
            $business_summary->total_commission          = $request->total_commission ;
            $business_summary->aeon_benefit              = $request->aeon_benefit ;
            $business_summary->remarks                   = $request->remarks ;
            $business_summary->status                    = $request->status ;
            $business_summary->created_by                = $request->created_by ;
            $business_summary->updated_by                = $request->updated_by ;

            $business_summary->save();
            $this->apiSuccess("Business Summary Updated Successfully");
            $this->data = (new BusinessSummaryResource($business_summary));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    /*
       Delete
    */
    public function delete(Request $request)
    {
        BusinessSummary::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Business Summary Deleted Successfully", 200);
    }
}
