<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalPath extends Model
{
    use HasFactory;
    public function poId(){
       return $this->belongsTo(ManualPo::class,"po_id");
    }

    public function labdipsEmbellishment(){
        return $this->belongsTo(LabDipsEmbellishmentInformation::class,"labdips_embellishment_id");
    }

    public function bulkFabricInformation(){
        return $this->belongsTo(BulkFabricInformation::class,"bulk_fabric_information_id");
    }

    public function mill(){
        return $this->belongsTo(Mill::class,"fabric_mill_id");
    }

    public function sampleApproval(){
        return $this->belongsTo(SampleApprovalInformation::class,"sample_approval_id");
    }

    public function ppMeeting(){
        return $this->belongsTo(PpMeeting::class,"pp_meeting_id");
    }

    public function productInformation(){
        return $this->belongsTo(ProductionInformation::class,"production_information_id");
    }

    public function inspectionInfo(){
        return $this->belongsTo(InspectionInformation::class,"inspection_information_id");
    }
}
