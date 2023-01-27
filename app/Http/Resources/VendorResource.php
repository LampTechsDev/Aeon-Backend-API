<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
     * Collection
     */
    // public static function collection($resource){
    //     return tap(new VendorResource($resource), function ($collection) {
    //         $collection->collects = __CLASS__;
    //     });
    // }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->filter([
            "id"             => $this->id ?? "",
            "name"           => $this->name ?? "",
            "logo"           => $this->logo ?? "Not Insert Logo",
            "address"        => $this->address ?? "",
            "email"          => $this->email ?? "",
            "contact_number" => $this->contact_number ?? "",
            "remarks"        => $this->remarks ?? "",
            "status"         => $this->status ?? "",
            "created_at"     => $this->created_at ?? "",
            "updated_at"     => $this->updated_at ?? "",
            // "deleted_by"     => $this->deleted_by ?? "",
            // "deleted_date"   => $this->deleted_date ?? "",
            // "groupId"       => $this->group_id ?? "",
            // "department"    => isset($this->group_id) ? (new GroupResource($this->groupId))->hide(["created_by", "updated_by"]) : null,
            "created_by"    => isset($this->created_by) ? (new AdminResource($this->createdBy))->hide(["created_by","updated_by"]) : null,
            "updated_by"    => isset($this->updated_by) ? (new AdminResource($this->updatedBy))->hide(["created_by","updated_by"]) : null
        ]);
    }
}
