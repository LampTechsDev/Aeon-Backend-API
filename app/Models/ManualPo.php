<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualPo extends Model
{
    use HasFactory;
    public function fileInfo(){
        return $this->hasMany(PoPictureGarments::class, 'po_id');
    }

    public function fileInfoArt(){
        return $this->hasMany(PoArtwork::class, 'po_id');
    }
}
