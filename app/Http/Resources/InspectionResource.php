<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InspectionResource extends JsonResource
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
            "id"                    => $this->id ?? null,
            "meeting_name"          => $this->meeting_name ?? null,
            "po_number"             => $this->po_number ?? null,
            "vendor_id"             => $this->vendor_id ?? null,
            "factory_id"            => $this->factory_id ?? null,
            "buyer_id"              => $this->buyer_id ?? null,
            "style_name_id"         => $this->style_name_id ?? null,
            "department_id"         => $this->department_id ?? null,
            "inspection_name"       => $this->inspection_name ?? null,
            "inspection_date"       => $this->inspection_date ?? null,
            "inspection_time"       => $this->inspection_time ?? null,
            "inspection_note"       => $this->inspection_note ?? null,
            "status"                => $this->status ?? null,
            "remarks"               => $this->remarks ?? null,
            "created_at"            => $this->created_at ?? null,
            "updated_at"            => $this->updated_at ?? null,


        ]);
    }
}
