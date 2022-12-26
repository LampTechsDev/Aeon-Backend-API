<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AeonContactResource extends JsonResource
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
            "id"                    => $this->id ?? "",
            "aeon_id"               => $this->aeon_id ?? "",
            "employee_id"           => $this->employee_id ?? "",
            "first_name"            => $this->first_name ?? "",
            "last_name"             => $this->last_name ?? "",
            "designation"           => $this->designation ?? "",
            "department"            => $this->department ?? "",
            "category"              => $this->category ?? "",
            "phone"                 => $this->phone ?? "",
            "email"                 => $this->email ?? "",
            "remarks"               => $this->remarks ?? "",
            "status"                => $this->status ?? "",
            "created_by"            => isset($this->created_by) ? (new AdminResource($this->created_by))->hide(["created_by","updated_by"]) : null,
            "updated_by"            => isset($this->updated_by) ? (new AdminResource($this->updatedBy))->hide(["created_by","updated_by"]) : null,
           
        ]);
    }
}
