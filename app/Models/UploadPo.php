<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadPo extends Model
{
    use HasFactory, SoftDeletes;

    public function supplier(){
        return $this->belongsTo(Supplier::class, "supplier_id");
    }
    public function customer(){
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function itemDetails(){
        return $this->hasMany(UploadPoItemDetails::class, "upload_po_id");
    }

}
