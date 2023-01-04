<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmbellishmentImageResource extends JsonResource
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

            "id" => $this->id,
            "labdips_embellishment_id" => $this->labdips_embellishment_id,
            "file_name_embellish_image"  => $this->file_name,
            "file_type_embellish_so_image"  => $this->type,
            "file_url"   => asset($this->file_url),
            "created_by"                => $this->created_by  ? (new AdminResource($this->createdBy)) : null,
            "updated_by"                => $this->updated_by  ? (new AdminResource($this->updatedBy)) : null,

        ]);
    }
}