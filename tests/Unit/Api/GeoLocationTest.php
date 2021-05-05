<?php

namespace Tests\Unit\Api;

use App\Models\RegisteredUser;
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
            RegisteredUser::find(1)            
        );           
        
        $response = $this->post('http://localhost:8000/api/v1/geo-locations', $this->getStoreRequest(8));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonGeoStructure);
    }

    public function test_StoreGeoAsProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(5)            
        );           
        
        $response = $this->post('http://localhost:8000/api/v1/geo-locations', $this->getStoreRequest(8));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonGeoStructure);
    }

    public function test_CircundantesPlazaBolivar()
    {
        $ltPlazaBolivarMzles = 5.068073743901081;
        $lngPlazaBolivarMzles = -75.51735301643926;
        $radio = 0.5; //500 metros
        
        $response = $this->get('http://localhost:8000/api/v1/events/geo/'.$ltPlazaBolivarMzles.'/'.$lngPlazaBolivarMzles.'/'.$radio); 
        
        $response->assertStatus(200);

        /*$response->assertJsonFragment([
            "data" => 
                [                
                    "type" => "GeoLocation",
                    "id" => 1,
                    "attributes" => [                        
                        "addr_id" => 1  // Dirección id 1 = Plaza Bolivar                      
                    ]                    
                ]
        ]);*/
        
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
