<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProducerResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'links' => [
                'self' => route('api.v1.producers.index')
            ],
            'meta' => [
                'count' => $this->collection->count()
            ],
            'data' => $this->collection
        ];
    }
}
