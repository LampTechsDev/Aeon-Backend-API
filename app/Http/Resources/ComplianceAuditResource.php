<?php

namespace App\Http\Resources;

use App\Models\ComplianceAuditUpload;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplianceAuditResource extends JsonResource
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
            "id"                                => $this->id ,
            "vendor_name"                       => $this->vendor_name,
            "manufacture_unit"                  => $this->manufacture_unit,
            "vendor_id"                         => isset($this->vendor) ? (new VendorResource($this->vendor))->hide(["created_by","updated_by"]) : null,
            "manufacturer_id"                   => isset($this->manufacture) ? (new VendorManufacturerResource($this->manufacture))->hide(["created_by","updated_by"]) : null,
            "factory_concern_person_name"       => isset($this->factoryConcern) ? (new ManufacturerContactPeopleResource($this->factoryConcern))->hide(["created_by","updated_by"]) : null,
            "audit_name"                        => $this->audit_name,
            "audit_conducted_by"                => isset($this->audit) ? (new AdminResource($this->audit))->hide(["created_by","updated_by"]) : null,
            "audit_requirement_details"         => $this->audit_requirement_details,
            "audit_date"                        => $this->audit_date,
            "audit_time"                        => $this->audit_time,
            "email"                             => $this->email,
            "phone"                             => $this->phone,
            "note"                              => $this->note,
            "type"                              => $this->type,
            "upload_files"                      => ComplianceAuditUploadResource::collection($this->fileInfo),
            
        ]);
    }
}
