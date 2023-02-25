<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class InvoiceController extends Controller
{

    public function index()
    {
       try{
        //return 10;
            // if(!PermissionController::hasAccess("group_list")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }
            $this->data = InvoiceResource::collection(Invoice::all());
            $this->apiSuccess("Invoice List Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

   /* public function store(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $invoice = new Invoice();
            $invoice->po_id = $request->po_id;
            $invoice->critical_path_id  = $request->critical_path_id;
            $invoice->ctns = $request->ctns;
            $invoice->quantity = $request->quantity;
            $invoice->consignee_bank = $request->consignee_bank;
            $invoice->negotiating_bank = $request->negotiating_bank;
            $invoice->save();
            $this->apiSuccess();
            $this->data = (new InvoiceResource($invoice));
            return $this->apiOutput("Invoice Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }*/

      /*
    Show
    */
    public function show(Request $request)
    {
        try{
            
            $invoice = Invoice::find($request->id);
            $this->data = (new InvoiceResource($invoice));
            $this->apiSuccess("Inspection Details Show Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function update(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $invoice = Invoice::find($request->id);
            //$invoice->po_id = $request->po_id;
            $invoice->ctns = $request->ctns;
            $invoice->quantity = $request->quantity;
            $invoice->consignee_bank = $request->consignee_bank;
            $invoice->negotiating_bank = $request->negotiating_bank;
            $invoice->save();
            $this->apiSuccess();
            $this->data = (new InvoiceResource($invoice));
            return $this->apiOutput("Invoice Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


}
