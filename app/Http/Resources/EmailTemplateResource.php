<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailTemplateResource extends JsonResource
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
            "id"            => $this->id,
            "email_type"    => $this->email_type,
            "subject"       => $this->subject,
            "mail_send"     => $this->mail_send,
            "cc"            => $this->cc,
            "template"      => $this->template,
            
            "created_by"    => isset($this->created_by) ? (new AdminResource($this->createdBy))->hide(["groupId","department", "created_by","updated_by"]) : null,
            "updated_by"    => isset($this->updated_by) ? (new AdminResource($this->updatedBy))->hide(["groupId","department", "created_by","updated_by"]) : null

        ]);
    }
}
