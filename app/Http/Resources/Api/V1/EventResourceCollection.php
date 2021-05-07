<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventResourceCollection extends ResourceCollection
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
                'self' => $request->id?route('api.v1.producer.events', $request->id):route('api.v1.events')
            ],
            'meta' => [
                'count' => $this->collection->count()
            ],
            'data' => $this->collection
        ];
    }
}
