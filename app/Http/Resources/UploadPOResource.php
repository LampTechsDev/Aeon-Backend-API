<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadPOResource extends JsonResource
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
            "is_read"       => $this->is_read ?? false,
            "issue_date"    => $this->issue_date ?? "",
            "due_date"      => $this->due_date ?? "",
            "supplier"      => $this->supplier ?? "",
            "customer"      => $this->customer ?? "",
            "created_at"    => $this->created_at ?? "",
            "updated_at"    => $this->updated_at ?? "",
            "item_details"  => $this->itemDetails,
        ]);
    }
}
