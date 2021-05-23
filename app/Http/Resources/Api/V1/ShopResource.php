<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'Shop',
            'id' => $this->id,
            'attributes' => [
                'producer_id' => $this->producer_id,
                'whatsapp' => $this->whatsapp,
                'phone' => $this->phone,
                'email' => $this->email,                
                'price_per_km' => $this->price_per_km,
                'max_shipping_distance' => $this->max_shipping_distance,                
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [
                'Addr'=> [
                    'data' => $this->addr?[
                        'type' => 'Addr',
                        'id' => $this->addr->id
                    ]:[]
                ]
            ],
            'links' => [
                'self' => route('api.v1.addrs.show', $this->id)
            ]
        ];
    }
}
