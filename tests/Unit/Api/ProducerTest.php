<?php

namespace Tests\Unit\Api;

use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ProducerTest extends TestCase
{
    const jsonProducerStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [                
                'id'
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
            User::find(6)            
        );

        $user_id = 6;       
        $response = $this->post('api/v1/producers', $this->getStoreRequest($user_id));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonProducerStructure);
    }

    public function test_UserStoreProducerOtherId()
    {
        Sanctum::actingAs(
            User::find(5)            
        );

        $user_id = 6;       
        $response = $this->post('api/v1/producers', $this->getStoreRequest($user_id));                     

        $response->assertStatus(401);
        
    }

    public function test_ShowMyProducerData()
    {
        Sanctum::actingAs(
            User::find(3)            
        );

        $response = $this->get('api/v1/producers/3');

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonProducerStructure);
    }

    public function test_ShowNotBelongsProducerData()
    {
        Sanctum::actingAs(
            User::find(3)            
        );

        $response = $this->get('api/v1/producers/4');

        $response->assertStatus(401); 
        
    }

    public function test_ShowProducerDataAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
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
                    "id" => $user_id
                ]                        
            ]
        ];
    }
}
