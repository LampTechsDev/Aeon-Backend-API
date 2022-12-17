<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminResourceCollection extends ResourceCollection
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
     * Process The Collection
     */
    protected function processCollection($request){
        return $this->collection->map(function (AdminResource $resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->processCollection($request);
    }
}

// <?php

// namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;

// class AdminResourceCollection extends ResourceCollection
// {
//     /**
//      * Transform the resource collection into an array.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
//      */
//     public function toArray($request)
//     {
//         return parent::toArray($request);
//     }
// }
