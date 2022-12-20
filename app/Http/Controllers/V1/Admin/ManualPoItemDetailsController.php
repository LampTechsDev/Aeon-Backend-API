<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManualPoItemDetailsResource;
use App\Models\ManualPoItemDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ManualPoItemDetailsController extends Controller
{

    public function index(){
        try{
                
            $this->data = ManualPoItemDetailsResource::collection(ManualPoItemDetails::all());
            $this->apiSuccess("Manual Po Item Details Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //'name'          => ["required", "min:4"],
                //'description'   => ["nullable", "min:4"],
                "po_id"      => ["required", "exists:manual_pos,id"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $manualpoItemDetails = new ManualPoItemDetails();
            $manualpoItemDetails->plm = $request->plm;
            $manualpoItemDetails->po_id = $request->po_id;
            $manualpoItemDetails->style_no = $request->style_no;
            $manualpoItemDetails->colour = $request->colour;
            $manualpoItemDetails->item_no = $request->item_no;
            $manualpoItemDetails->size = $request->size;
            $manualpoItemDetails->qty_order = $request->qty_order;
            $manualpoItemDetails->inner_qty = $request->inner_qty;
            $manualpoItemDetails->outer_case_qty = $request->outer_case_qty;
            $manualpoItemDetails->supplier_price = $request->supplier_price;
            $manualpoItemDetails->value = $request->value;
            $manualpoItemDetails->selling_price = $request->selling_price;
            $manualpoItemDetails->save();
            $this->apiSuccess();
            $this->data = (new ManualPoItemDetailsResource($manualpoItemDetails));
            return $this->apiOutput("Manual Po Item Details Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }



    public function update(Request $request){
        try{
            $validator = Validator::make( $request->all(),[
                //'name'          => ["required", "min:4"],
                //'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $manualpoItemDetails = ManualPoItemDetails::find($request->id);
            $manualpoItemDetails->plm = $request->plm;
            $manualpoItemDetails->po_id = $request->po_id;
            $manualpoItemDetails->style_no = $request->style_no;
            $manualpoItemDetails->colour = $request->colour;
            $manualpoItemDetails->item_no = $request->item_no;
            $manualpoItemDetails->size = $request->size;
            $manualpoItemDetails->qty_order = $request->qty_order;
            $manualpoItemDetails->inner_qty = $request->inner_qty;
            $manualpoItemDetails->outer_case_qty = $request->outer_case_qty;
            $manualpoItemDetails->supplier_price = $request->supplier_price;
            $manualpoItemDetails->value = $request->value;
            $manualpoItemDetails->selling_price = $request->selling_price;
            $manualpoItemDetails->save();
            $this->apiSuccess();
            $this->data = (new ManualPoItemDetailsResource($manualpoItemDetails));
            return $this->apiOutput("Manual Po Item Details Added Successfully");

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
            
            $manualpoItemDetails = ManualPoItemDetails::find($request->id);
            $this->data = (new ManualPoItemDetailsResource($manualpoItemDetails));
            $this->apiSuccess("ManualPo Item Details Showed Successfully");
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
        ManualPoItemDetails::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("ManualPo Item Details Deleted Successfully", 200);
    }
}
