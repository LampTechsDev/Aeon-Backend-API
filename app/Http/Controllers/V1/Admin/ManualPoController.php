<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManualPoResource;
use App\Models\ManualPo;
use App\Models\ManualPoDeliveryDetails;
use App\Models\ManualPoItemDetails;
use App\Models\PoArtwork;
use App\Models\PoPictureGarments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class ManualPoController extends Controller
{


    public function index(){
        try{
                
                $this->data = ManualPoResource::collection(ManualPo::all());
                $this->apiSuccess("Manual Po Loaded Successfully");
                return $this->apiOutput();
    
            }catch(Exception $e){
                return $this->apiOutput($this->getError($e), 500);
            }
    }

     /*
    Store
    */

    public function store(Request $request){
       
        try{
            $validator = Validator::make( $request->all(),[
                //'name'          => ["required", "min:4"],
                //'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();
   
            $manualpo = new ManualPo();
            $manualpo->buyer_id = $request->buyer_id;
            $manualpo->vendor_id = $request->vendor_id;
            $manualpo->	note = $request->note;
            $manualpo->terms_conditions = $request->terms_conditions;
            $manualpo->first_delivery_date = $request->first_delivery_date;
            $manualpo->second_shipment_date = $request->second_shipment_date;
            $manualpo->vendor_po_date = $request->vendor_po_date;
            $manualpo->current_buyer_po_price = $request->current_buyer_po_price;
            $manualpo->vendor_po_price = $request->vendor_po_price;
            $manualpo->accessorize_price = $request->accessorize_price;
            $manualpo->plm_no = $request->plm_no;
            $manualpo->description = $request->description;
            $manualpo->fabric_quality = $request->fabric_quality;
            $manualpo->fabric_content = $request->fabric_content;
            $manualpo->save();
            $this->saveFileInfo($request, $manualpo);
            $this->saveExtraFileInfo($request, $manualpo);
            $this->deliveryDetails($request,$manualpo);
            //$this->itemdetails($request,$manualpo);
            DB::commit();
            $this->apiSuccess();
            $this->data = (new ManualPoResource($manualpo));
            return $this->apiOutput("Manual Po Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    // Save File Info
    public function saveFileInfo($request, $manualpo){
        $file_path = $this->uploadFile($request, 'file', $this->pogarments_uploads, 720);
  
        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PoPictureGarments();
            $data->po_id = $manualpo->id;
            $data->file_name    = $request->file_name ?? "PO_Picture_Garments Upload";
            $data->file_url     = $path;
            $data->type = $request->type;
            $data->save();
           
        }
    }


    // Save Extra File Info
    public function saveExtraFileInfo($request, $manualpo){
        $file_path = $this->uploadFile($request, 'poArtwork', $this->poartworks_uploads, 720);
  
        if( !is_array($file_path) ){
            $file_path = (array) $file_path;
        }
        foreach($file_path as $path){
            $data = new PoArtwork();
            $data->po_id = $manualpo->id;
            $data->file_name    = $request->file_name ?? "PO_Art_Works Upload";
            $data->file_url     = $path;
            $data->type = $request->typeArtwork;
            $data->save();
           
        }
    }


    public function deliveryDetails($request, $manualpo){

            $data = new ManualPoDeliveryDetails();
            $data->po_id = $manualpo->id;
            $data->ship_method = $request->ship_method;
            $data->inco_terms = $request->inco_terms;
            $data->landing_port = $request->landing_port;
            $data->discharge_port = $request->discharge_port;
            $data->country_of_origin = $request->country_of_origin;
            $data->ex_factor_date = $request->ex_factor_date;
            $data->care_label_date = $request->care_label_date;
            $data->save();
    }


    // public function itemdetails($request,$manualpo){

    //         $manualpoItemDetails = new ManualPoItemDetails();
    //         $manualpoItemDetails->po_id = $request->po_id;
    //         $manualpoItemDetails->plm = $request->plm;
    //         $manualpoItemDetails->style_no = $request->style_no;
    //         $manualpoItemDetails->colour = $request->colour;
    //         $manualpoItemDetails->item_no = $request->item_no;
    //         $manualpoItemDetails->size = $request->size;
    //         $manualpoItemDetails->qty_order = $request->qty_order;
    //         $manualpoItemDetails->inner_qty = $request->inner_qty;
    //         $manualpoItemDetails->outer_case_qty = $request->outer_case_qty;
    //         $manualpoItemDetails->supplier_price = $request->supplier_price;
    //         $manualpoItemDetails->value = $request->value;
    //         $manualpoItemDetails->selling_price = $request->selling_price;
    //         $manualpoItemDetails->save();
    // }


     /*
    Show
    */
    public function show(Request $request)
    {
        try{
            
            $manualpo = ManualPo::find($request->id);
            $this->data = (new ManualPoResource($manualpo));
            $this->apiSuccess("ManualPo Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }


      /*
    Update
    */

    public function update(Request $request){
       
        try{
            $validator = Validator::make( $request->all(),[
                //'name'          => ["required", "min:4"],
                //'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
            DB::beginTransaction();
   
            $manualpo = ManualPo::find($request->id);
            $manualpo->buyer_id = $request->buyer_id;
            $manualpo->vendor_id = $request->vendor_id;
            $manualpo->	note = $request->note;
            $manualpo->terms_conditions = $request->terms_conditions;
            $manualpo->first_delivery_date = $request->first_delivery_date;
            $manualpo->second_shipment_date = $request->second_shipment_date;
            $manualpo->vendor_po_date = $request->vendor_po_date;
            $manualpo->current_buyer_po_price = $request->current_buyer_po_price;
            $manualpo->vendor_po_price = $request->vendor_po_price;
            $manualpo->accessorize_price = $request->accessorize_price;
            $manualpo->plm_no = $request->plm_no;
            $manualpo->description = $request->description;
            $manualpo->fabric_quality = $request->fabric_quality;
            $manualpo->fabric_content = $request->fabric_content;
            $manualpo->save();
            $this->deliveryDetails($request,$manualpo);
            $this->itemdetails($request,$manualpo);
            DB::commit();
            $this->apiSuccess();
            $this->data = (new ManualPoResource($manualpo));
            return $this->apiOutput("Manual Po Updated Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


     /*
       Delete
    */
    public function delete(Request $request)
    {
        ManualPo::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("ManualPo Deleted Successfully", 200);
    }


    
}
