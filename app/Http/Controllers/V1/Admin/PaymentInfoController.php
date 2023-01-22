<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentInfoController extends Controller
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

            $payment = new Payment();
            $payment->po_number = $request->po_number;
            $payment->po_id=$request->po_id;
            $payment->late_delivery_discount=$request->late_delivery_discount;
            $payment->invoice_number=$request->invoice_number;
            $payment->invoice_create_date=$request->invoice_create_date;
            $payment->payment_receive_date=$request->payment_receive_date;
            $payment->save();
            DB::commit();
            $this->apiSuccess();
            $this->data = (new PaymentResource($payment));
            return $this->apiOutput("Payment Added Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
