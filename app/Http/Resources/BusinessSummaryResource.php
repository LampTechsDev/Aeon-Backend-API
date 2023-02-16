<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessSummaryResource extends JsonResource
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
    //     return tap(new VendorProfileCollection($resource), function ($collection) {
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
            "id"                        => $this->id ?? "",
            "po_id"                     => $this->po_id ?? "",
            "final_total_ship_qty"      => $this->final_total_ship_qty ?? "",
            "final_total_invoice_value" => $this->final_total_invoice_value ?? "",
            "total_commission"          => $this->total_commission ?? "",
            "aeon_benefit"              => $this->aeon_benefit ?? "",
            "remarks"                   => $this->remarks ?? "",
            "status"                    => $this->status ?? "",
            "created_by"                => $this->created_by ?? "",
            "updated_by"                => $this->updated_by ?? "",
        ]);
    }
}
