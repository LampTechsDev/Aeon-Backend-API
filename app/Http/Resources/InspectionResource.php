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
                "inspection_name"       => $this->inspection_name ?? null,
                "inspection_date"       => $this->inspection_date ?? null,
                "inspection_time"       => $this->inspection_time ?? null,
                "inspection_note"       => $this->inspection_note ?? null,
                "po_info"        =>  isset($this->poDetails) ? (new ManualPoResource($this->poDetails))->hide(["created_by","updated_by"]) : null,
                "assign_to_user"                  =>  isset($this->assignUser) ? (new AdminResource($this->assignUser))->hide(["groupId","department", "created_by","updated_by"]) : null,
                "status"                => $this->status ?? null,
                "remarks"               => $this->remarks ?? null,
                "created_at"            => $this->created_at ?? null,
                "updated_at"            => $this->updated_at ?? null,


        ]);
    }
}
