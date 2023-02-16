<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSummary extends Model
{
    use HasFactory;
    public function poId(){
        return $this->belongsTo(ManualPo::class, 'po_id');
    }

}
