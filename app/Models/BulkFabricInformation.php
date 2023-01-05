<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkFabricInformation extends Model
{
    use HasFactory;
    public function fileInfo(){
        return $this->hasMany(BulkFabricKnitDownImage::class, 'bulk_fabric_information_id');
    }
}
