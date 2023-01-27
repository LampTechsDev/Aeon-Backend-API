<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExFactoryResource extends JsonResource
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
            "po_number"          => $this->po_number ?? "",
            "po_id"         => $this->po_id ?? "",
            "ex_factory_date_po"       => $this->ex_factory_date_po ?? "",
            "revised_ex_factory_date"        => $this->revised_ex_factory_date ?? "",
            "shipped_units"   => $this->shipped_units ?? "",
            "original_eta_sa_date"  => $this->original_eta_sa_date ?? "",
            "revised_eta_sa_date"   => $this->revised_eta_sa_date ?? "",
            "forwarded_ref_vessel_name" => $this->forwarded_ref_vessel_name ?? "",
            "created_at"    => $this->created_at ?? "",
            "updated_at"    => $this->updated_at ?? "",
        ]);
    }
}
