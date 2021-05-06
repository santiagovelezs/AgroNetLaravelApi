<?php

namespace Tests\Unit\Api;

use App\Models\RegisteredUser;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ProducerTest extends TestCase
{
    const jsonProducerStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [
                'sede_ppal'
            ],
            'relationships',
            'links'          
       ]
    ];

    const jsonStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes', 
            'relationships',    
            'links'          
       ]
    ];

    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_StoreProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(6)            
        );

        $user_id = 6;       
        $response = $this->post('api/v1/producers', $this->getStoreRequest($user_id));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonProducerStructure);
    }

    public function test_UserStoreProducerOtherId()
    {
        Sanctum::actingAs(
            RegisteredUser::find(5)            
        );

        $user_id = 6;       
        $response = $this->post('api/v1/producers', $this->getStoreRequest($user_id));                     

        $response->assertStatus(401);
        
    }

    public function test_ShowMyProducerData()
    {
        Sanctum::actingAs(
            RegisteredUser::find(3)            
        );

        $response = $this->get('api/v1/producers/3');

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonProducerStructure);
    }

    public function test_ShowNotBelongsProducerData()
    {
        Sanctum::actingAs(
            RegisteredUser::find(3)            
        );

        $response = $this->get('api/v1/producers/4');

        $response->assertStatus(401); 
        
    }

    public function test_ShowProducerDataAsAdmin()
    {
        Sanctum::actingAs(
            RegisteredUser::find(1)            
        );

        $response = $this->get('api/v1/producers/3');

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonProducerStructure);
    }

    private function getStoreRequest($user_id)
    {
        return [
            "data" => [
                "type" => "Producer",
                "attributes" => [                            
                    "sede_papal" => null,
                    "registered_user_id" => $user_id
                ]                        
            ]
        ];
    }
}
