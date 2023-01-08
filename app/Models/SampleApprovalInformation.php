<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleApprovalInformation extends Model
{
    use HasFactory;
    public function samplefileInfo(){
        return $this->hasMany(PhotoSample::class, 'sample_approval_id');
    }


}
