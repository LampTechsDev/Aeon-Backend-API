<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorCertificateResource extends JsonResource
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
    //     return tap(new VendorCertificateCollection($resource), function ($collection) {
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

            "id"                      => $this->id ?? "",
            "vendor_id"               => $this->vendor_id ?? "",
            "global_certificate_id"   => $this->global_certificate_id ?? "",
            "certificate_name"        => $this->certificate_name ?? "",
            "certificate_logo"        => $this->certificate_logo ?? "",
            "issue_date"              => $this->issue_date ?? "",
            "validity_start_date"     => $this->validity_start_date ?? "",
            "validity_end_date"       => $this->validity_end_date ?? "",
            "renewal_date"            => $this->renewal_date ?? "",
            "score"                   => $this->score ?? "",

            "remarks"                 => $this->remarks ?? "",
            "status"                  => $this->status ?? "",
            "upload_files"            => VendorCertificateAttachFileUploadResource::collection($this->fileInfo) ?? "",

            "created_by"              => isset($this->created_by) ? (new AdminResource($this->created_by))->hide(["created_by","updated_by,deleted_by,deleted_date"]) : null,
            "updated_by"              => isset($this->updated_by) ? (new AdminResource($this->updatedBy))->hide(["created_by","updated_by,deleted_by,deleted_date"]) : null,
            "deleted_by"              => isset($this->deleted_by) ? (new AdminResource($this->deleted_by))->hide(["created_by","updated_by,deleted_by,deleted_date"]) : null,
            "deleted_date"            => isset($this->deleted_date) ? (new AdminResource($this->deleted_date))->hide(["created_by","updated_by,deleted_by,deleted_date"]) : null,

        ]);
    }
}
