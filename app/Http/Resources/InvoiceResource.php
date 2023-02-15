<?php

namespace App\Http\Resources;

use App\Models\FinishingReportUpload;
use App\Models\PreFinalAqlReportUpload;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            "id"                           => $this->id ?? "",
            "po_info"                      => isset($this->poInvoice) ? (new ManualPoResource($this->poInvoice))->hide(["created_by", "updated_by"]) : null,
            "ctns"                         => $this->ctns ?? "",
            "quantity"                     => $this->quantity ?? "",
            "created_at"                   => $this->created_at ?? "",
            "updated_at"                   => $this->updated_at ?? "",
           
        ]);
    }
}
