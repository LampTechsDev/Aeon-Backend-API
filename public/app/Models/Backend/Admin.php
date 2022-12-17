<?php

namespace App\Models\Backend;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $casts = [
        "status"    => "boolean",
    ];

    public function createdBy(){
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }
    public function group(){
        return $this->belongsTo(Group::class, "group_id");
    }
    public function groupId(){
        return $this->belongsTo(Group::class, "group_id");
    }
}
