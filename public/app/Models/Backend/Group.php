<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function createdBy(){
        return $this->belongsTo(Admin::class, "created_by")->withTrashed();
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class, "updated_by")->withTrashed();
    }
    public function groupAccess(){
        return $this->hasOne(GroupAccess::class, "group_id")->orderBy("id", "DESC");
    }
}
