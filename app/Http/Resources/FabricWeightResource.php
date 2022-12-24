<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FabricWeightResource extends JsonResource
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
            "name"          => $this->name ?? "",
            "details"       => $this->details?? "",
            "status"        => $this->status?? "",
            "fabric_content"    => isset($this->fabricContent) ? (new FabricContentResource($this->fabricContent))->hide(["created_by", "updated_by"]) : null,
            "created_at"    => $this->created_at?? "",
            "updated_at"    => $this->updated_at?? "",
        ]);
    }
}
