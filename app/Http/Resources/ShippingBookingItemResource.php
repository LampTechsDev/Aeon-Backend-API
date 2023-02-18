<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingBookingItemResource extends JsonResource
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
            "shipping_booking_id"          => $this->shipping_booking_id,
            "line_code"       => $this->line_code ?? "",
            "no_of_packages"     => $this->no_of_packages ?? "",
            "no_of_pieces"           => $this->no_of_pieces ?? "",
            "gross_wt"    => $this->gross_wt ?? "",
            "authorized"               => $this->authorized ?? "",
            "status"          => $this->status ?? "",
            "created_at"    => $this->created_at ?? "",
            "updated_at"    => $this->updated_at ?? "",
        ]);
    }
}
