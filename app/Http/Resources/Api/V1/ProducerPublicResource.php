<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProducerPublicResource extends JsonResource
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
            'type' => 'Producer',
            'id' => $this->id,
            'attributes' => [
                'nombre' => $this->owner->nombre,
                'apellido' => $this->owner->apellido,
                'email' => $this->owner->email,
                'departamento' => $this->owner->departamento,
                'ciudad' => $this->owner->ciudad,
                'telefono' => $this->owner->telefono                
            ],
            'relationships' => [
            ],
            'links' => [
                'self' => route('api.v1.users.show',$this->id)
            ]
        ];
    }
}
