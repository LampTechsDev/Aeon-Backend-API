<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingBookingResource;
use App\Models\ShippingBook;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class ShippingBookController extends Controller
{
    public function index()
    {
       try{

            $this->data = ShippingBookingResource::collection(ShippingBook::all());
            $this->apiSuccess("Shipping Booking Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }

            $shippingbook = new ShippingBook();
            $shippingbook->critical_path_id    = $request->critical_path_id;
            $shippingbook->booking_date        = $request->booking_date;
            $shippingbook ->cargo_delivery_date=$request->cargo_delivery_date;
            $shippingbook ->so_number          =$request->so_number;
            $shippingbook ->bank_id            =$request->bank_id;
            $shippingbook ->cf_agent_details   =$request->cf_agent_details;
            $shippingbook ->lc_no              =$request->lc_no;
            $shippingbook ->invoice_no         =$request->invoice_no;
            $shippingbook ->exp_no             =$request->exp_no;
            $shippingbook ->description_goods  =$request->description_goods;
            $shippingbook ->status             =$request->status;
            $shippingbook ->freight_id         =$request->freight_id;
            $shippingbook->save();
            $this->apiSuccess();
            $this->data = (new ShippingBookingResource($shippingbook));
            return $this->apiOutput("Shipping Booking Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{

            $shipping = ShippingBook::find($request->id);
            $this->data = (new ShippingBookingResource($shipping));
            $this->apiSuccess("Shipping Booking Showed Successfully");
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
        ShippingBook::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Shipping Booking Deleted Successfully", 200);
    }
}
