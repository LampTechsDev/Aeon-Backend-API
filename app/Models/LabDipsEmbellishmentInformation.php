<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabDipsEmbellishmentInformation extends Model
{
    use HasFactory;
    public function labDipfileInfo(){
        return $this->hasMany(LabDipImage::class, 'labdips_embellishment_id');
    }

    public function embellishMentfileInfo(){
        return $this->hasMany(EmbellishmentImage::class, 'labdips_embellishment_id');
    }


}
