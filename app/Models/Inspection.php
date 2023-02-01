<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;
    public function poDetails(){
        return $this->belongsTo(ManualPo::class, 'po_id');
    }
    public function assignUser(){
        return $this->belongsTo(Admin::class, "assign_to_user");
    }
}
