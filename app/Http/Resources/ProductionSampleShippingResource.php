<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductionSampleShippingResource extends JsonResource
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
            "po_id"                                       => $this->po_id ?? "",
            "po_number"                                   => $this->po_number ?? "",
            "development_photo_sample_sent_plan"          => $this->development_photo_sample_sent_plan ?? "",
            "development_photo_sample_sent_actual"        => $this->development_photo_sample_sent_actual ?? "",
            "development_photo_sample_dispatch_details"   => $this->development_photo_sample_dispatch_details ?? "",
            "fit_approval_plan"                           => $this->fit_approval_plan ?? "",
            "fit_approval_actual"                         => $this->fit_approval_actual ?? "",
            "fit_sample_dispatch_details"                 => $this->fit_sample_dispatch_details ?? "",
            "fit_sample_dispatch_sending_date"            => $this->fit_sample_dispatch_sending_date ?? "",
            "fit_sample_dispatch_aob_number"              => $this->fit_sample_dispatch_aob_number ?? "",
            "size_set_approval_plan"                      => $this->size_set_approval_plan ?? "",
            "size_set_approval_actual"                    => $this->size_set_approval_actual ?? "",
            "size_set_sample_dispatch_details"            => $this->size_set_sample_dispatch_details ?? "",
            "size_set_sample_dispatch_sending_date"       => $this->size_set_sample_dispatch_sending_date ?? "",
            "size_set_sample_dispatch_aob_number"         => $this->size_set_sample_dispatch_aob_number ?? "",
            "pp_approval_plan"                            => $this->pp_approval_plan ?? "",
            "pp_approval_actual"                          => $this->pp_approval_actual ?? "",
            "pp_sample_dispatch_details"                  => $this->pp_sample_dispatch_details ?? "",
            "pp_sample_sending_date"                      => $this->pp_sample_sending_date ?? "",
            "pp_sample_courier_aob_number"                => $this->pp_sample_courier_aob_number ?? "",
            "created_at"                                  => $this->created_at ?? "",
            "updated_at"                                  => $this->updated_at ?? "",
            "photo_sample_image"                          => PhotoSampleImageResource::collection($this->samplefileInfo),
            "fit_sample_image"                            => FitSampleImageResource::collection($this->fitSampleImagefileInfo),
            "size_set_sample_image"                       => SizeSetSampleImageResource::collection($this->sizeSetSampleImagefileInfo),
            "pp_sample_image"                             => PpImageResource::collection($this->ppSampleImagefileInfo),
            


        ]);
    }
}
