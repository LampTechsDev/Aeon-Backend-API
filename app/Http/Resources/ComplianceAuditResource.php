<?php

namespace App\Http\Resources;

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
            "id"                            => $this->id ,
            "factory_name"                  => $this->factory_name,
            "factory_concern_person_name"   => $this->factory_concern_person_name,
            "status"                        => $this->status,
            "email"                         => $this->email,
            "phone"                         => $this->phone,
            "audit_name"                    => $this->audit_name,
            "vendor_name"                   => $this->vendor_name,
            "audit_conducted_by"            => $this->audit_conducted_by,
            "audit_request_date"            => $this->audit_request_date,
            "requirement_date"              => $this->requirement_date,
            "requirement_details"           => $this->requirement_details,
            "upload_files"                  => ComplianceAuditUploadResource::collection($this->fileInfo),
            "note_remarks"                  => $this->note_remarks,
        ]);
    }
}
