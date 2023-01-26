<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalPathMasterFile extends Model
{
    use HasFactory;
    // public function criticalPath(){
    //     return $this->belongsTo(CriticalPath::class,"critical_path_id");
    // }
    public function department(){
        return $this->belongsTo(CriticalPathDepartment::class,"critical_path_departments_id");
    }
}
