<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleShippingApproval extends Model
{
    use HasFactory;
    
    public function fileInfo(){
        return $this->hasMany(ProductionSampleImage::class, 'sample_shipping_approvals_id');
    }
}
