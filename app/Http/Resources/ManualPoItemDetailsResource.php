<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManualPoItemDetailsResource extends JsonResource
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
            "po_id"                     => $this->po_id ?? "",
            "plm"                       => $this->plm ?? "",
            "style_no"                  => $this->style_no ?? "",
            "colour"                    => $this->colour ?? "",
            "swing_tag"                 => $this->swing_tag ?? "",
            "item_no"                   => $this->item_no ?? "",
            "size"                      => $this->size ?? "",
            "qty_order"                 => $this->qty_order ?? "",
            "inner_qty"                 => $this->inner_qty ?? "",
            "outer_case_qty"            => $this->outer_case_qty ?? "",
            "value"                     => $this->value ?? "",
            "selling_price"             => $this->selling_price ?? "",
            "created_at"                => $this->created_at ?? "",
            "updated_at"                => $this->updated_at ?? "",

        ]);
    }
}
