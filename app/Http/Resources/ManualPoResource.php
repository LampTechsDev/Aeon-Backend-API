<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManualPoResource extends JsonResource
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
            
            "id"                        => $this->id ?? null,
            "note"                      => $this->note ?? null,
            "terms_conditions"          => $this->terms_conditions ?? null,
            "first_delivery_date"       => $this->first_delivery_date ?? null,
            "second_shipment_date"      => $this->second_shipment_date ?? null,
            "vendor_po_date"            => $this->vendor_po_date ?? null,
            "current_buyer_po_price"    => $this->current_buyer_po_price ?? null,
            "vendor_po_price"           => $this->vendor_po_price ?? null,
            "accessorize_price"         => $this->accessorize_price ?? null,
            "plm_no"                    => $this->plm_no ?? null,
            "description"               => $this->description ?? null,
            "fabric_quality"            => $this->fabric_quality ?? null,
            "fabric_content"            => $this->fabric_content ?? null,
            "currency"                  => $this->currency ?? null,
            "payment_method"            => $this->payment_method ?? null,
            "payment_terms"             => $this->payment_terms ?? null,
            "fabric_weight"             => $this->fabric_weight ?? null,
            "po_no"                     => $this->po_no ?? null,
            "created_at"                => $this->created_at ?? null,
            "updated_at"                => $this->updated_at ?? null,
            "upload_files"              => PictureGarmentsResource::collection($this->fileInfo),
            "upload_files_artwork"      => PoArtworkResource::collection($this-> fileInfoArt),
            "manualPoDeliveryDetails"               => ManualPoDeliveryDetailsResource::collection($this->manualpoDeliveryDetails),
            "buyer_info"                  =>isset($this->buyer) ? (new CustomerResource($this->buyer))->hide(["created_by", "updated_by"]) : null,
            "vendor_info"                 =>isset($this->vendor) ? (new VendorResource($this->vendor))->hide(["created_by", "updated_by"]) : null,
            "supplier_info"                =>isset($this->supplier) ? (new SupplierResource($this->supplier))->hide(["created_by", "updated_by"]) : null,
            "manufacturer_info"            =>isset($this->manufacturer) ? (new VendorManufacturerResource($this->manufacturer))->hide(["created_by", "updated_by"]) : null,
            "customer_department_info"            =>isset($this->customerDepartment) ? (new CustomerDepartmentResource($this->customerDepartment))->hide(["created_by", "updated_by"]) : null,

           


        ]);
    }
}
