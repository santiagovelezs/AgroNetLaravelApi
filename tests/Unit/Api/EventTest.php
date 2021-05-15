<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class EventTest extends TestCase
{
    const jsonEventStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [
                'producer_id',
                'addr_id',
                'fecha',
                'hora',
                'duracion',
                'title',
                'desc',
                'state',
                'created_at',
                'updated_at'
            ],
            'relationships' => [
                'Addr' => [
                    'data' => [
                        'type',
                        'id'
                    ]
                ]
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
    public function test_AllEvents()
    {
        $response = $this->get('api/v1/events');

        $response->assertStatus(200); 

        $response->assertJsonFragment(['current_page' => 1]); 
    }

    public function test_StoreEventAsProducer()
    {
        Sanctum::actingAs(
            User::find(2)            
        );

        $producer_id = 2;

        $addr_id = 1;
             
        $response = $this->post('api/v1/events', $this->getStoreRequest($producer_id, $addr_id));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonEventStructure);
    }

    public function test_StoreEventAsAdmin()
    {
        Sanctum::actingAs(
            User::find(1)            
        );

        $user_id = 2;

        $addr_id = 1;
             
        $response = $this->post('api/v1/events', $this->getStoreRequest($user_id, $addr_id));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonEventStructure);
    }

    public function test_StoreEventAsRegisteredUser()
    {
        Sanctum::actingAs(
            User::find(5)            
        );

        $producer_id = 2;

        $addr_id = 1;
             
        $response = $this->post('api/v1/events', $this->getStoreRequest($producer_id, $addr_id));                     

        $response->assertStatus(401);
        
    }

    public function test_ShowEvent()
    {
        $response = $this->get('api/v1/events/1');

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonStructure);
    }

    public function test_NotExistsEvent()
    {
        $response = $this->get('api/v1/events/100');

        $response->assertStatus(404);         
    }

    public function test_AddrEvent()
    {
        $response = $this->get('api/v1/events/1/addr');

        $response->assertStatus(200); 

        $response->assertJsonFragment(['type' => 'addr']);

        $response->assertJsonFragment(['id' => 1]);
    }

    public function test_GeoEvent()
    {
        $response = $this->get('api/v1/events/1/geo-location');

        $response->assertStatus(200); 

        $response->assertJsonFragment(['type' => 'GeoLocation']);

        $response->assertJsonFragment(['id' => 1]);
    }

    public function test_NearEvents()
    {
        $ltPlazaBolivarMzles = 5.068073743901081;
        $lngPlazaBolivarMzles = -75.51735301643926;
        $radio = 0.5; //500 metros
        
        $response = $this->get('api/v1/events/'.$ltPlazaBolivarMzles.'/'.$lngPlazaBolivarMzles.'/'.$radio); 
        
        $response->assertStatus(200);       

        $response->assertJsonFragment(['type' => 'Event']);
        $response->assertJsonFragment(['id' => 1]); //Evento Plaza Bolivar
        $response->assertJsonFragment(['id' => 2]); //Evento Plaza Alfonso Lopez
    }

    public function test_EventsBetweenDate()
    {
        $date1 = '2021-09-14';
        $date2 = '2021-10-20';    
        $response = $this->get('api/v1/events/date/between/'.$date1.'/'.$date2); 
        
        $response->assertStatus(200);       

        $response->assertJsonFragment(['fecha' => '2021-10-20',]); 
        $response->assertJsonFragment(['fecha' => '2021-09-29',]); 
       
    }

    private function getStoreRequest($producer_id, $addr_id)
    {
        return [
            "data" => [
                "type" => "Event",
                "attributes" => [                   
                    "producer_id" => $producer_id,
                    'addr_id' => $addr_id,
                    'fecha' => '2020/10/19',
                    'hora' => '17:00',
                    'duracion' => 3,
                    'title' => 'Test Event',
                    'desc' => null
                ]                        
            ]
        ];
    }
}
