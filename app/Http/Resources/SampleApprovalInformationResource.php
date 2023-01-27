<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SampleApprovalInformationResource extends JsonResource
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

                "id"                                          => $this->id ?? "",
                "po_id"                                       => $this->po_id ?? "",   
                "po_number"                                   => $this->po_number ?? "",
                "production_sample_approval_plan"             => $this->production_sample_approval_plan ?? "",
                "production_sample_approval_actual"           => $this->production_sample_approval_actual ?? "",
                "production_sample_dispatch_details"          => $this->production_sample_dispatch_details ?? "",
                "production_sample_dispatch_sending_date"     => $this->production_sample_dispatch_sending_date ?? "",
                "production_sample_dispatch_aob_number"       => $this->production_sample_dispatch_aob_number ?? "",
                "shipment_booking_with_acs_plan"              => $this->shipment_booking_with_acs_plan ?? "",
                "shipment_booking_with_acs_actual"            => $this->shipment_booking_with_acs_actual ?? "",
                "sa_approval_plan"                            => $this->sa_approval_plan ?? "",
                "sa_approval_actual"                          => $this->sa_approval_actual ?? "",
                "created_at"                                  => $this->created_at ?? "",
                "updated_at"                                  => $this->updated_at ?? "",
                "production_sample_image"                             => ProductionSampleImageResource::collection($this->fileInfo),
                


        ]);
    }
}
