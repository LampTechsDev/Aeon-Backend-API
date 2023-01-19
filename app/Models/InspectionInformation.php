<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionInformation extends Model
{
    use HasFactory;
    public function fileInfo(){
        return $this->hasMany(sewing_report_upload::class, 'inspection_information_id');
    }
    public function finishingReportInfo(){
        return $this->hasMany(FinishingReportUpload::class, 'inspection_information_id');
    }
    public function preFinalReportInfo(){
        return $this->hasMany(PreFinalAqlReportUpload::class, 'inspection_information_id');
    }
    public function finalAqlReportInfo(){
        return $this->hasMany(FinalAqlReportUpload::class, 'inspection_information_id');
    }
    

}
