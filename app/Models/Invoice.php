<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public function poInvoice(){
        return $this->belongsTo(ManualPo::class,"po_id");
     }

     public function criticalInvoice(){
        return $this->belongsTo(CriticalPath::class, "critical_path_id");
     }

}
