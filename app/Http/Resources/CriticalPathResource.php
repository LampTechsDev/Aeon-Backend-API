<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CriticalPathResource extends JsonResource
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
            "id"                                       => $this->id ?? "",
            "inspection_information"                   => isset($this->inspectionInfo) ? (new InspectionInformationResource($this->inspectionInfo))->hide(["created_by","updated_by"]) : null,
            "po_info"                                  => isset($this->poId) ? (new ManualPoResource($this->poId))->hide(["created_by","updated_by"]) : null,
            "labdips_embellishment_info"               => isset($this->labdipsEmbellishment) ? (new LabDipsEmbellishmentInformationResource($this->labdipsEmbellishment))->hide(["created_by","updated_by"]) : null,
            "bulk_fabric_information_info"             => isset($this->bulkFabricInformation) ? (new BulkFabricInformationResource($this->bulkFabricInformation))->hide(["created_by","updated_by"]) : null,
            "fabric_mill_info"                         => isset($this->mill) ?(new MillResource($this->mill))->hide(["created_by","updated_by"]) : null,
            "sample_approval_info"                     => isset($this->sampleApproval) ?(new SampleApprovalInformationResource($this->sampleApproval))->hide(["created_by","updated_by"]) : null,
            "pp_meeting_info"                          => isset($this->ppMeeting) ?(new PpMeetingResource($this->ppMeeting))->hide(["created_by","updated_by"]) : null,
            "production_information_info"              => isset($this->productInformation) ?(new ProductInformationResource($this->productInformation))->hide(["created_by","updated_by"]) : null,
            "lead_times"                               => $this->lead_times?? "",
            "lead_type"                                => $this->lead_type?? "",
            "official_po_plan"                         => $this->official_po_plan??"",
            "official_po_actual"                       => $this->official_po_actual??"",
            "created_at"                               => $this->created_at ?? "",
            "updated_at"                               => $this->updated_at ?? "",
            "created_by"                               => isset($this->created_by) ? (new AdminResource($this->createdBy))->hide(["groupId","department", "created_by","updated_by"]) : null,
            "updated_by"                               => isset($this->updated_by) ? (new AdminResource($this->updatedBy))->hide(["groupId","department", "created_by","updated_by"]) : null
        ]);
    }
}
