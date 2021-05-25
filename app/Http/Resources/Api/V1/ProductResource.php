<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => 'Product',
            'id' => $this->id,
            'attributes' => [
                'producer_id' => $this->producer_id,
                'category_id' => $this->category_id,
                'image_path'  => $this->image_path,
                'name'        => $this->name,
                'description' => $this->description,
                'measurement' => $this->measurement,
                'price' => $this->price,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
