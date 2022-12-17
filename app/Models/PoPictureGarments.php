<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoPictureGarments extends Model
{
    use HasFactory;
    public function manualpo(){
        return $this->belongsTo(ManualPo::class, 'po_id');
    }
}
