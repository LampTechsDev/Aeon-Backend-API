<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingBookingItem extends Model
{
    use HasFactory;
    public function shippingBooking(){
        return $this->belongsTo(ShippingBook::class,"shipping_booking_id");
    }
}
