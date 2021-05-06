<?php

namespace Tests\Unit\Api;

use App\Models\RegisteredUser;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddrTest extends TestCase
{ 
    const jsonAddrStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [
                'registered_user_id',
                'country',
                'province',
                'city',
                'street',
                'location',
                'etiqueta',
                'created_at',
                'updated_at',
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
    public function test_StoreAddrAsAdmin()
    {
        Sanctum::actingAs(
            RegisteredUser::find(1)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(5));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAddrStructure);
        
    }

    public function test_StoreAddrAsProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(2)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(2));

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAddrStructure);
        
    }

    public function test_StoreAddrNotBelongsAsProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(2)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(3));                     

        $response->assertStatus(401);        
        
    }

    public function test_StoreAddrAsUser()
    {
        Sanctum::actingAs(
            RegisteredUser::find(4)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(4));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAddrStructure);
        
    }

    public function test_StoreAddrNotBelongsAsUser()
    {
        Sanctum::actingAs(
            RegisteredUser::find(4)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(5));                     

        $response->assertStatus(401);        
        
    }

    public function test_getAddrAsAdmin()
    {
        Sanctum::actingAs(
            RegisteredUser::find(1)            
        );           
        
        $response = $this->get('api/v1/addrs/1');                     

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonAddrStructure);
    }

    public function test_getAddrNotBelongsAsProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(2)            
        );           
        
        $response = $this->get('api/v1/addrs/5');                     

        $response->assertStatus(404); 
    }

    public function test_getGeoByAddrAsAdmin()
    {
        Sanctum::actingAs(
            RegisteredUser::find(1)            
        );           
        
        $response = $this->get('api/v1/addrs/5/geo-location');                     

        $response->assertJsonStructure($this::jsonStructure); 
    }

    public function test_getGeoByAddrNotBelongsAsProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(2)            
        );           
        
        $response = $this->get('api/v1/addrs/5/geo-location');                     

        $response->assertStatus(404);  
    }

    public function test_getGeoByAddrAsProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(2)            
        );           
        
        $response = $this->get('api/v1/addrs/3/geo-location');                     

        $response->assertJsonStructure($this::jsonStructure); 
    }

    private function getStoreRequest($registered_user_id)
    {
        return [
            "data" => [
                "type" => "Address",
                "attributes" => [                            
                    "registered_user_id" => $registered_user_id,
                    "country" => "Colombia",
                    "province" => "Caldas",
                    "city"=> "Salamina",
                    "street" => "Av 55",
                    "location" => "# 10",
                    "etiqueta" => "Casa"
                ]                        
            ]
        ];
    }
}
