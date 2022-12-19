<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualPoItemDetails extends Model
{
    use HasFactory;
    public function manualPo(){
        return $this->belongsTo(ManualPo::class, 'po_id');
    }
}
