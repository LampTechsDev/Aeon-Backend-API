<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductInformationResource extends JsonResource
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
            "id"                                    => $this->id ?? "",
            "cutting_date_plan"                     => $this->cutting_date_plan ?? "",
            "cutting_date_actual"                   => $this->cutting_date_actual ?? "",
            "embellishment_plan"                    => $this->embellishment_plan ?? "",
            "embellishment_actual"                  => $this->embellishment_actual ?? "",
            "sewing_start_date_plan"                => $this->sewing_start_date_plan ?? "",
            "sewing_start_date_actual"              => $this->sewing_start_date_actual ?? "",
            "sewing_complete_date_plan"             => $this->sewing_complete_date_plan ?? "",
            "sewing_complete_date_actual"           => $this->sewing_complete_date_actual ?? "",
            "created_at"                            => $this->created_at ?? "",
            "updated_at"                            => $this->updated_at ?? "",
        ]);
    }
}
