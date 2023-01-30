<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerProfile extends Model
{
    use HasFactory;
    // public function createdBy(){
    //     return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    // }
    // public function updatedBy(){
    //     return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    // }
    public function fileInfo(){
        return $this->hasMany(ManufacturerProfileAttachFileUpload::class, 'manufactur_p_id');
    }

}
