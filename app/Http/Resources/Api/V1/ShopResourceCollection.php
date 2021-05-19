<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopResourceCollection extends ResourceCollection
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
                'self' => $request->id?route('api.v1.user.addrs', $request->id):route('api.v1.api.v1.addrs.index')
            ],
            'meta' => [
                'count' => $this->collection->count()
            ],
            'data' => $this->collection
        ];
    }
}
