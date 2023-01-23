<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionManagementOrderDetails extends Model
{
    use HasFactory;
    public function criticalPath(){
        return $this->belongsTo(CriticalPath::class, 'critical_path_id');
    }

}
