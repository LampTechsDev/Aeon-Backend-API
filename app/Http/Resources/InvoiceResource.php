<?php

namespace App\Http\Resources;

use App\Models\FinishingReportUpload;
use App\Models\PreFinalAqlReportUpload;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    protected $withoutFields = [];

    /**
     * Set Hidden Item 
     */
    public function hide(array $hide = []){
        $this->withoutFields = $hide;
        return $this;
    }

    /**
     * Filter Hide Items
     */
    protected function filter($data){
        return collect($data)->forget($this->withoutFields)->toArray();
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->filter([
            "id"                           => $this->id ?? "",
            "critical_path_info"           => isset($this->criticalInvoice) ? (new CriticalPathResource($this->criticalInvoice))->hide(["created_by", "updated_by","inspection_information","labdips_embellishment_info","bulk_fabric_information_info","sample_approval_info","pp_meeting_info","production_information_info","ex-factory_eta_vessel_information","payment_information"]) : null,
            "ctns"                         => $this->ctns ?? "",
            "quantity"                     => $this->quantity ?? "",
            "created_at"                   => $this->created_at ?? "",
            "updated_at"                   => $this->updated_at ?? "",
           
        ]);
    }
}
