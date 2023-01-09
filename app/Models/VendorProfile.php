<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class VendorProfile extends Model
{
    use HasFactory;
    public function createdBy(){
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }
    public function fileInfo(){
        return $this->hasMany(VendorProfileAttachFileUpload::class, 'vendor_profile_id');
    }
    public function manufacturerprofile(){
        return $this->belongsTo(ManufacturerProfile::class, "vendor_id");
    }
}
