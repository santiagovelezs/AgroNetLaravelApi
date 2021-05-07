<?php

namespace Tests\Unit\Api;

use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class GeoLocationTest extends TestCase
{
    const jsonGeoStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [
                'latitud',
                'longitud', 
                'addr_id',
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
    public function test_StoreGeoAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );           
        
        $response = $this->post('api/v1/geo-locations', $this->getStoreRequest(8));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonGeoStructure);
    }

    public function test_StoreGeoAsProducer()
    {
        Sanctum::actingAs(
            User::find(5)            
        );           
        
        $response = $this->post('api/v1/geo-locations', $this->getStoreRequest(8));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonGeoStructure);
    }

    public function test_CircundantesPlazaBolivar()
    {
        $ltPlazaBolivarMzles = 5.068073743901081;
        $lngPlazaBolivarMzles = -75.51735301643926;
        $radio = 0.5; //500 metros
        
        $response = $this->get('api/v1/events/geo/'.$ltPlazaBolivarMzles.'/'.$lngPlazaBolivarMzles.'/'.$radio); 
        
        $response->assertStatus(200);       

        $response->assertJsonFragment(['addr_id' => 1]); // Dirección id 1 = Plaza Bolivar 
        $response->assertJsonFragment(['addr_id' => 2]); // Dirección id 2 = Plaza Alfonso López
        
    }

    public function test_Distance()
    {
        $ltRioBlanco = 5.086888739523445;
        $lngRioBlanco = -75.43064233704608;
        $radio = 2; //2 km
        
        $response = $this->get('api/v1/events/geo/'.$ltRioBlanco.'/'.$lngRioBlanco.'/'.$radio); 
        
        $response->assertStatus(200);       

        $response->assertJsonFragment(['count' => 0]);        
        
    }

    private function getStoreRequest($addr_id)
    {
        return [
            "data" => [
                "type" => "GeoLocation",
                "attributes" => [                            
                    "latitud" => -5.278785453,
                    "longitud" => 71.87864567,
                    "addr_id" => $addr_id
                ]                        
            ]
        ];
    }

   
}
