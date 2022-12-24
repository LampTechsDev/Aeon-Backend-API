<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricWeight extends Model
{
    use HasFactory;
    public function fabricContent(){
        return $this->belongsTo(FabricContent::class, "fabric_content_id");
    }
}
