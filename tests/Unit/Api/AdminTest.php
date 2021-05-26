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
    
    public function test_StoreAdminAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );           
        
        $response = $this->post('api/v1/admin/admin', $this->getStoreRequest(7));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAdminStructure);
        
    }
    
    public function test_StoreAdminAsUser()
    {
        Sanctum::actingAs(
            User::find(5)            
        );           
        
        $response = $this->post('api/v1/admin/admin', $this->getStoreRequest(5));                     

        $response->assertStatus(401);       
        
    }

    public function test_StoreAdminAsProducer()
    {
        Sanctum::actingAs(
            User::find(2)            
        );           
        
        $response = $this->post('api/v1/admin/admin', $this->getStoreRequest(2));                     

        $response->assertStatus(401);       
        
    }

    public function test_ShowAdminData()
    {
        Sanctum::actingAs(
            User::find(1)            
        );

        $response = $this->get('api/v1/admin/admin/1');

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonAdminStructure);
    }

    public function test_ShowAdminDataAsUser()
    {
        Sanctum::actingAs(
            User::find(5)            
        );

        $response = $this->get('api/v1/admin/admin/1');

        $response->assertStatus(401); 

    }

    public function test_DeleteSuperAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );

        $response = $this->delete('api/v1/admin/admin/1');

        $response->assertStatus(401); 

    }

    public function test_DeleteOtherAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );

        $this->post('api/v1/admin/admin', $this->getStoreRequest(2)); 

        $response = $this->delete('api/v1/admin/admin/2');

        $response->assertStatus(204); 

    }

    public function test_DisableUser()
    {
        Sanctum::actingAs(
            User::find(1)            
        );       

        $response = $this->delete('api/v1/admin/disable-user/2');

        $response->assertStatus(200); 

        $response02 = $this->get('api/v1/users/2');

        $response02->assertStatus(404);

    }

    public function test_ActivateUser()
    {
        Sanctum::actingAs(
            User::find(1)            
        );       

        $response = $this->delete('api/v1/admin/disable-user/2');

        $response->assertStatus(200); 

        $response02 = $this->post('api/v1/admin/activate-user/2');

        $response02->assertStatus(204);

        $response02 = $this->get('api/v1/users/2');

        $response02->assertStatus(200);

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
