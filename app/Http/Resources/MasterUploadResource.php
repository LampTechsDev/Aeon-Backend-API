<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterUploadResource extends JsonResource
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
            "critical_path_id" => $this->critical_path_id,
            "critical_path_department_info" => isset($this->department) ? (new CriticalPathDepartmentResource($this->department))->hide(["created_by","updated_by"]) : null,
            "file_name"  => $this->file_name,
            "file_type"  => $this->type,
            "file_url"   => asset($this->file_url),
            "created_by"                => $this->created_by  ? (new AdminResource($this->createdBy)) : null,
            "updated_by"                => $this->updated_by  ? (new AdminResource($this->updatedBy)) : null,

        ]);
    }
}