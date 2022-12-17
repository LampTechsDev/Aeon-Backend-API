<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAccess extends Model
{
    use HasFactory;
    protected $casts = [
        "group_access"  => "array",
    ];
}
