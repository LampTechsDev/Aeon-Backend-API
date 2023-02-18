<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingBookingResource extends JsonResource
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
            "id"            => $this->id ?? "",
            "critical_path_info"          => isset($this->criticalPathInfo) ? (new CriticalPathResource($this->criticalPathInfo))->hide(["created_by", "updated_by"]) : null,
            "booking_date"       => $this->booking_date ?? "",
            "cargo_delivery_date"     => $this->cargo_delivery_date ?? "",
            "so_number"           => $this->so_number ?? "",
            "shipper_consigned_information"             => isset($this->bank) ? (new BankResource($this->bank))->hide(["created_by", "updated_by"]) : null,
            "cf_agent_details"    => $this->cf_agent_details ?? "",
            "lc_no"               => $this->lc_no ?? "",
            "invoice_no"          => $this->invoice_no ?? "",
            "exp_no"              => $this->exp_no ?? "",
            "description_goods"   => $this->description_goods ?? "",
            "freight_info"          => isset($this->freight) ? (new FreightManagementResource($this->freight))->hide(["created_by", "updated_by"]) : null,
            "created_at"    => $this->created_at ?? "",
            "updated_at"    => $this->updated_at ?? "",
        ]);
    }
}
