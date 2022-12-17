<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManualPoDeliveryDetailsResource extends JsonResource
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
            "id"                        => $this->id ?? "",
            "ship_method"               => $this->ship_method ?? "",
            "inco_terms"                => $this->inco_terms ?? "",
            "landing_port"              => $this->landing_port ?? "",
            "discharge_port"            => $this->discharge_port ?? "",
            "country_of_origin"         => $this->country_of_origin ?? "",
            "ex_factor_date"            => $this->ex_factor_date ?? "",
            "care_label_date"           => $this->care_label_date ?? "",
            "created_at"                => $this->created_at ?? "",
            "updated_at"                => $this->updated_at ?? "",
        ]);
    }
}
