<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSummary extends Model
{
    use HasFactory;
    public function businessSummary(){
        return $this->belongsTo(ManualPo::class, 'po_id');
    }
}
