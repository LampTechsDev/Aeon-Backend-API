<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LabDipsEmbellishmentInformationResource extends JsonResource
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
            "id"                                                      =>  $this->id ?? "",
            "po_number"                                               =>  $this->po_number ?? "",
            "po_id"                                                   =>  $this->po_id ?? "",
            "colour_std_print_artwork_sent_to_supplier_plan"          =>  $this->colour_std_print_artwork_sent_to_supplier_plan ?? "",
            "colour_std_print_artwork_sent_to_supplier_plan_buyer"    =>  $this->colour_std_print_artwork_sent_to_supplier_plan_buyer ?? "",
            "colour_std_print_artwork_sent_to_supplier_actual"        =>  $this->colour_std_print_artwork_sent_to_supplier_actual ?? "",
            "lab_dip_approval_plan"                                   =>  $this->lab_dip_approval_plan ?? "",
            "lab_dip_approval_plan_buyer"                             =>  $this->lab_dip_approval_plan_buyer ?? "",
            "lab_dip_approval_actual"                                 =>  $this->lab_dip_approval_actual ?? "",
            "lab_dip_dispatch_details"                                =>  $this->lab_dip_dispatch_details ?? "",
            "lab_dip_dispatch_sending_date"                           =>  $this->lab_dip_dispatch_sending_date ?? "",
            "lab_dip_dispatch_aob_number"                             =>  $this->lab_dip_dispatch_aob_number ?? "",
            "embellishment_so_approval_plan"                          =>  $this->embellishment_so_approval_plan ?? "",
            "embellishment_so_approval_plan_buyer"                    =>  $this->embellishment_so_approval_plan_buyer ?? "",
            "embellishment_so_approval_actual"                        =>  $this->embellishment_so_approval_actual ?? "",
            "embellishment_so_dispatch_details"                       =>  $this->embellishment_so_dispatch_details ?? "",
            "embellishment_so_dispatch_sending_date"                  =>  $this->embellishment_so_dispatch_sending_date ?? "",
            "embellishment_so_dispatch_aob_number"                    =>  $this->embellishment_so_dispatch_aob_number ?? "",
            "created_at"                                              =>  $this->created_at ?? "",
            "updated_at"                                              =>  $this->updated_at ?? "",
            "labDips_upload_file"                                     =>  LabDipImageResource::collection($this-> labDipfileInfo),
            "embellishment_so_image"                                  =>  EmbellishmentImageResource::collection($this->embellishMentfileInfo),

        ]);
    }
}
