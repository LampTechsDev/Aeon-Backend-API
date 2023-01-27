<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            "id"            => $this->id ?? "",
            "po_number"          => $this->po_number ?? "",
            "po_id"         => $this->po_id ?? "",
            "late_delivery_discount"       => $this->late_delivery_discount ?? "",
            "invoice_number"        => $this->invoice_number ?? "",
            "invoice_create_date"   => $this->invoice_create_date ?? "",
            "payment_receive_date"  => $this->payment_receive_date ?? "",
            "created_at"    => $this->created_at ?? "",
            "updated_at"    => $this->updated_at ?? "",
        ]);
    }
}
