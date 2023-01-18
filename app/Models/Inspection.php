<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;
    public function itemDetails(){
        return $this->belongsTo(ManualPoItemDetails::class, 'item_details_id');
    }
    public function assignUser(){
        return $this->belongsTo(Admin::class, "assign_to_user");
    }
}
