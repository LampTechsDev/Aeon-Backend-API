<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpMeeting extends Model
{
    use HasFactory;
    public function fileInfo(){
        return $this->hasMany(PpMeetingReportUpload::class, 'pp_meeting_id');
    }

}
