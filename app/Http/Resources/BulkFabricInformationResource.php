<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BulkFabricInformationResource extends JsonResource
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
            "id"                                            => $this->id ?? "",
            "po_number"                                     => $this->po_number ?? "",
            "po_id"                                         => $this->po_id ?? "",
            "fabric_ordered_plan"                           => $this->fabric_ordered_plan ?? "",
            "fabric_ordered_plan_buyer"                     => $this->fabric_ordered_plan_buyer ?? "",
            "fabric_ordered_actual"                         => $this->fabric_ordered_actual ?? "",
            "bulk_fabric_knit_down_approval_plan"           => $this->bulk_fabric_knit_down_approval_plan ?? "",
            "bulk_fabric_knit_down_approval_plan_buyer"     => $this->bulk_fabric_knit_down_approval_plan_buyer ?? "",
            "bulk_fabric_knit_down_approval_actual"         => $this->bulk_fabric_knit_down_approval_actual ?? "",
            "bulk_fabric_knit_down_dispatch_details"        => $this->bulk_fabric_knit_down_dispatch_details ?? "",
            "bulk_fabric_knit_down_dispatch_sending_date"   => $this->bulk_fabric_knit_down_dispatch_sending_date ?? "",
            "bulk_fabric_knit_down_dispatch_aob_number"     => $this->bulk_fabric_knit_down_dispatch_aob_number ?? "",
            "bulk_yarn_fabric_inhouse_plan"                 => $this->bulk_yarn_fabric_inhouse_plan ?? "",
            "bulk_yarn_fabric_inhouse_plan_buyer"           => $this->bulk_yarn_fabric_inhouse_plan_buyer ?? "",
            "bulk_yarn_fabric_inhouse_actual"               => $this->bulk_yarn_fabric_inhouse_actual ?? "",
            "created_at"                                    => $this->created_at ?? "",
            "updated_at"                                    => $this->updated_at ?? "",
            "upload_files"                                  => BulkFabricKnitDownImageResource::collection($this->fileInfo),



        ]);
    }
}
