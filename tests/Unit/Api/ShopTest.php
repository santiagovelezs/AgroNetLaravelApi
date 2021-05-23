<?php

namespace Tests\Unit\Api;

use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShopTest extends TestCase
{ 
    const jsonAddrStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [
                'producer_id',
                'whatsapp' ,
                'phone',
                'email',                
                'price_per_km',  
                'max_shipping_distance'           
            ],
            'relationships' => [
                'Addr'
            ],
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
    public function test_StoreShopAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );           
        
        $response = $this->post('api/v1/shops', $this->getStoreRequest());                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAddrStructure);
        
    }

    /*public function test_StoreAddrAsProducer()
    {
        Sanctum::actingAs(
            User::find(2)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(2));

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAddrStructure);
        
    }*/

    /*public function test_StoreAddrNotBelongsAsProducer()
    {
        Sanctum::actingAs(
            User::find(2)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(3));                     

        $response->assertStatus(401);        
        
    }*/

    /*public function test_StoreAddrAsUser()
    {
        Sanctum::actingAs(
            User::find(4)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(4));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonAddrStructure);
        
    }*/

    /*public function test_StoreAddrNotBelongsAsUser()
    {
        Sanctum::actingAs(
            User::find(4)            
        );           
        
        $response = $this->post('api/v1/addrs', $this->getStoreRequest(5));                     

        $response->assertStatus(401);        
        
    }*/

    /*public function test_getAddrAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );           
        
        $response = $this->get('api/v1/addrs/1');                     

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonAddrStructure);
    }*/

    /*public function test_getAddrNotBelongsAsProducer()
    {
        Sanctum::actingAs(
            User::find(2)            
        );           
        
        $response = $this->get('api/v1/addrs/5');                     

        $response->assertStatus(404); 
    }*/

    /*public function test_getGeoByAddrAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );           
        
        $response = $this->get('api/v1/addrs/5/geo-location');                     

        $response->assertJsonStructure($this::jsonStructure); 
    }*/

    /*public function test_getGeoByAddrNotBelongsAsProducer()
    {
        Sanctum::actingAs(
            User::find(2)            
        );           
        
        $response = $this->get('api/v1/addrs/5/geo-location');                     

        $response->assertStatus(404);  
    }*/

    /*public function test_getGeoByAddrAsProducer()
    {
        Sanctum::actingAs(
            User::find(2)            
        );           
        
        $response = $this->get('api/v1/addrs/3/geo-location');                     

        $response->assertJsonStructure($this::jsonStructure); 
    }*/

    private function getStoreRequest()
    {
        return [
            "data" => [
                "type" => "Shop",
                "attributes" => [                            
                    "producer_id" => 3,
                    "whatsapp" => "9878985",
                    "phone" => "5874141",
                    "email"=> "lamaria@mail.es",
                    "addr_id" => 5,
                    "price_per_km" => 900,
                    "max_shipping_distance" => 15
                ]                        
            ]
        ];
    }
}
