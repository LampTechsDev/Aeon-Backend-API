<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingBook extends Model
{
    use HasFactory;

    public function criticalPathInfo(){
        return $this->belongsTo(CriticalPath::class, "critical_path_id");
    }

    public function bank(){
        return $this->belongsTo(Bank::class, "bank_id");
    }

    public function freight(){
        return $this->belongsTo(FreightManagement::class, "freight_id");
    }

    public function shippingBookingItem(){
        return $this->hasMany(ShippingBookingItem::class,"shipping_booking_id");
    }

    
}
