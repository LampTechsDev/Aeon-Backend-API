<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;
    public function fileInfo(){
        return $this->hasMany(ComplianceAuditUpload::class, 'complianceaudit_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function manufacture(){
        return $this->belongsTo(VendorManufacturer::class, 'manufacturer_id');
    }

    public function audit(){
        return $this->belongsTo(Admin::class, 'audit_conducted_by');
    }
}
