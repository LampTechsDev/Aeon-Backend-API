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

    public function fitSampleImagefileInfo(){
        return $this->hasMany(FitSampleImage::class, 'sample_approval_id');
    }

    public function sizeSetSampleImagefileInfo(){
        return $this->hasMany(SizeSetSampleImage::class, 'sample_approval_id');
    }

    public function ppSampleImagefileInfo(){
        return $this->hasMany(PpSampleImage::class, 'sample_approval_id');
    }


}
