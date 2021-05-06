<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'type' => 'News',
            'id' => $this->id,
            'attributes' => [
                'user_id' => $this->producer->owner->id,
                'title' => $this->title,
                'content' => $this->content,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [
            ],
            'links' => [
                'self' => 'route()'
            ]
        ];
    }
}
