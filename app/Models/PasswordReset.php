<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    public function user(){
        return $this->morphTo(__FUNCTION__, "tableable", "tableable_id");
    }
}
