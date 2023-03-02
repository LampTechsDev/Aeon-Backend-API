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
            "invoice_no"                   => $this->invoice_no ?? "",
            "invoice_date"                 => $this->invoice_date ?? "",
            "sales_con_no"                 => $this->sales_con_no ?? "",
            "sales_con_date"               => $this->sales_con_date ?? "",
            "exp_no"                       => $this->exp_no ?? "",
            "exp_no_date"                  => $this->exp_no_date ?? "",
            "status"                       => $this->status ?? "",
            "consignee_bank"               => $this->consignee_bank ?? "",
            "negotiating_bank"             => $this->negotiating_bank ?? "",
            "created_at"                   => $this->created_at ?? "",
            "updated_at"                   => $this->updated_at ?? "",

        ]);
    }
}
