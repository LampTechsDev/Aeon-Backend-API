<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PpMeetingResource extends JsonResource
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
            "id"                                => $this->id ?? "",
            "po_id"                             => $this->po_id ?? "",
            "po_number"                         => $this->po_number ?? "",
            "care_label_approval_plan"          => $this->care_label_approval_plan ?? "",
            "care_label_approval_actual"        => $this->care_label_approval_actual ?? "",
            "material_inhouse_date_plan"        => $this->material_inhouse_date_plan ?? "",
            "material_inhouse_date_actual"      => $this->material_inhouse_date_actual ?? "",
            "pp_meeting_date_plan"              => $this->pp_meeting_date_plan ?? "",
            "pp_meeting_date_actual"            => $this->pp_meeting_date_actual ?? "",
            "pp_meeting_schedule"               => $this->pp_meeting_schedule ?? "",
            "created_at"                        => $this->created_at ?? "",
            "updated_at"                        => $this->updated_at ?? "",
            "upload_fiels"                      =>  PpMeetingUploadResource::collection($this->fileInfo),
        ]);
    }
}
