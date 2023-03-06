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
            "po_id"                                 => $this->po_id ?? "",
            "po_number"                             => $this->po_number ?? "",
            "cutting_date_plan"                     => $this->cutting_date_plan ?? "",
            "cutting_date_plan_buyer"               => $this->cutting_date_plan_buyer ?? "",
            "cutting_date_actual"                   => $this->cutting_date_actual ?? "",
            "embellishment_plan"                    => $this->embellishment_plan ?? "",
            "embellishment_plan_buyer"              => $this->embellishment_plan_buyer ?? "",
            "embellishment_actual"                  => $this->embellishment_actual ?? "",
            "sewing_start_date_plan"                => $this->sewing_start_date_plan ?? "",
            "sewing_start_date_plan_buyer"          => $this->sewing_start_date_plan_buyer ?? "",
            "sewing_start_date_actual"              => $this->sewing_start_date_actual ?? "",
            "sewing_complete_date_plan"             => $this->sewing_complete_date_plan ?? "",
            "sewing_complete_date_plan_buyer"       => $this->sewing_complete_date_plan_buyer ?? "",
            "sewing_complete_date_actual"           => $this->sewing_complete_date_actual ?? "",
            "washing_complete_date_plan"            => $this->washing_complete_date_plan ?? "",
            "washing_complete_date_plan_buyer"      => $this->washing_complete_date_plan_buyer ?? "",
            "washing_complete_date_actual"          => $this->washing_complete_date_actual ?? "",
            "finishing_complete_date_plan"          => $this->finishing_complete_date_plan ?? "",
            "finishing_complete_date_plan_buyer"    => $this->finishing_complete_date_plan_buyer ?? "",
            "finishing_complete_date_actual"        => $this->finishing_complete_date_actual ?? "",
            "created_at"                            => $this->created_at ?? "",
            "updated_at"                            => $this->updated_at ?? "",
        ]);
    }
}
