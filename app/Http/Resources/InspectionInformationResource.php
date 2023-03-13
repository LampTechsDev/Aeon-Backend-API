<?php

namespace App\Http\Resources;

use App\Models\FinishingReportUpload;
use App\Models\PreFinalAqlReportUpload;
use Illuminate\Http\Resources\Json\JsonResource;

class InspectionInformationResource extends JsonResource
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
            "id"                                      => $this->id ?? "",
            "po_number"                               => $this->po_number ?? "",
            "po_id"                                   => $this->po_id ?? "",
            "sewing_inline_inspection_date_plan"      => $this->sewing_inline_inspection_date_plan ?? "",
            "sewing_inline_inspection_date_plan_buyer"=> $this->sewing_inline_inspection_date_plan_buyer ?? "",
            "sewing_inline_inspection_date_actual"    => $this->sewing_inline_inspection_date_actual ?? "",
            "inline_inspection_schedule"              => $this->inline_inspection_schedule ?? "",
            "finishing_inline_inspection_date_plan"   => $this->finishing_inline_inspection_date_plan ?? "",
            "finishing_inline_inspection_date_plan_buyer"=> $this->finishing_inline_inspection_date_plan_buyer ?? "",
            "finishing_inline_inspection_date_actual" => $this->finishing_inline_inspection_date_actual ?? "",
            "finishing_inline_inspection_schedule"    => $this->finishing_inline_inspection_schedule ?? "",
            "pre_final_date_plan"                     => $this->pre_final_date_plan ?? "",
            "pre_final_date_plan_buyer"               => $this->pre_final_date_plan_buyer ?? "",
            "pre_final_date_actual"                   => $this->pre_final_date_actual ?? "",
            "pre_final_aql_schedule"                  => $this->pre_final_aql_schedule ?? "",
            "final_aql_date_plan"                     => $this->final_aql_date_plan ?? "",
            "final_aql_date_plan_buyer"               => $this->final_aql_date_plan_buyer ?? "",
            "final_aql_date_actual"                   => $this->final_aql_date_actual ?? "",
            "final_aql_meeting_schedule"              => $this->final_aql_meeting_schedule ?? "",
            "final_aql_schedule"                      => $this->final_aql_schedule ?? "",
            "created_at"                              => $this->created_at ?? "",
            "updated_at"                              => $this->updated_at ?? "",
            "sewing_upload_files"                     => SewingReportUploadResource::collection($this->fileInfo),
            "finishing_report_upload_files"           => FinishingReportUploadResource::collection($this->finishingReportInfo),
            "pre_final_report_upload_files"           => PreFinalAqlReportUploadResource::collection($this->preFinalReportInfo),
            "final_aql_upload_files"                  => FinalAqlUploadResource::collection($this->finalAqlReportInfo),

        ]);
    }
}
