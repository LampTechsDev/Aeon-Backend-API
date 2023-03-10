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
            $this->data = InvoiceResource::collection(Invoice::all());
            $this->apiSuccess("Invoice List Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

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

            $validator = Validator::make( $request->all(),[]);

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }

            $invoice = Invoice::find($request->id);
            $invoice->ctns             = $request->ctns;
            $invoice->quantity         = $request->quantity;
            $invoice->invoice_no       = $request->invoice_no;
            $invoice->invoice_date     = $request->invoice_date;
            $invoice->sales_con_no     = $request->sales_con_no;
            $invoice->sales_con_date   = $request->sales_con_date;
            $invoice->exp_no           = $request->exp_no;
            $invoice->exp_no_date      = $request->exp_no_date;
            $invoice->status           = $request->status;
            $invoice->consignee_bank   = $request->consignee_bank;
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
