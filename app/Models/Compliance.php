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
}
