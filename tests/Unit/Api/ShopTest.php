<?php

namespace Tests\Unit\Api;

use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShopTest extends TestCase
{ 
    const jsonShopStructure = [
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
        
        $producer_id = 3;
        
        $response = $this->post('api/v1/shops', $this->getStoreRequest($producer_id));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonShopStructure);
        
    }

    public function test_StoreShopAsProducer()
    {
        $producer_id = 3;

        Sanctum::actingAs(
            User::find($producer_id)            
        );          
        
        
        $response = $this->post('api/v1/shops', $this->getStoreRequest($producer_id));

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonShopStructure);
        
    }

    public function test_StoreShopNotBelongsAsProducer()
    {
        $producer_id = 3;
        $otherProducer_id = 12;

        Sanctum::actingAs(
            User::find($producer_id)            
        );           
        
        $response = $this->post('api/v1/shops', $this->getStoreRequest($otherProducer_id));                     

        $response->assertStatus(401);        
        
    }   

    public function test_getShop()
    {                  
        
        $response = $this->get('api/v1/shops/1');                     

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonShopStructure);
    }   
    
    public function test_inZone()
    {
        Sanctum::actingAs(
            User::find(5)            
        ); 

        $addr_chinchina = 8;
        $producer_id_shop_palestina = 2;

        $response = $this->get('api/v1/shops/1/shipping-price?producer='.$producer_id_shop_palestina.'&addrto='.$addr_chinchina);  

        $response->assertStatus(200); 

        $response->assertJsonFragment([
            'inZone' => true
        ]);

    }

    private function getStoreRequest($producer_id)
    {
        return [
            "data" => [
                "type" => "Shop",
                "attributes" => [                            
                    "producer_id" => $producer_id,
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
