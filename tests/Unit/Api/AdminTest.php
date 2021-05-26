<?php

namespace Tests\Unit\Api;

use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends TestCase
{ 
    const jsonAdminStructure = [
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
    public function test_StoreAdminAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );           
        
        $response = $this->post('api/v1/admin/admin', $this->getStoreRequest(7));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAdminStructure);
        
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
