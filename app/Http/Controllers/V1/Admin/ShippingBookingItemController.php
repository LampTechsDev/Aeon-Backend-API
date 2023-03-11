<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingBookingItemResource;
use App\Models\ShippingBookingItem;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class ShippingBookingItemController extends Controller
{

    public function index()
    {
       try{

            $this->data = ShippingBookingItemResource::collection(ShippingBookingItem::all());
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

            $shippingbookItem = new ShippingBookingItem();
            $shippingbookItem->shipping_booking_id  =   $request->shipping_booking_id;
            $shippingbookItem->line_code            =   $request->line_code;
            $shippingbookItem ->no_of_packages      =   $request->no_of_packages;
            $shippingbookItem ->no_of_pieces        =   $request->no_of_pieces;
            $shippingbookItem ->gross_wt            =   $request->gross_wt;
            $shippingbookItem ->authorized          =   $request->authorized;
            $shippingbookItem ->status              =   $request->status;
            $shippingbookItem->save();
            $this->apiSuccess();
            $this->data = (new ShippingBookingItemResource($shippingbookItem));
            return $this->apiOutput("Shipping Booking Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
