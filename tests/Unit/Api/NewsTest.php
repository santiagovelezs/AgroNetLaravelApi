<?php

namespace Tests\Unit\Api;

use App\Models\RegisteredUser;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class NewsTest extends TestCase
{
    const jsonNewsStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [
                'user_id',
                'title',
                'content',                
                'created_at',
                'updated_at'
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
    public function test_AllNews()
    {
        $response = $this->get('api/v1/news');

        $response->assertStatus(200); 

        $response->assertJsonFragment(['current_page' => 1]); 
    }

    public function test_StoreNewsAsProducer()
    {
        Sanctum::actingAs(
            RegisteredUser::find(2)            
        );

        $user_id = 2;        
             
        $response = $this->post('api/v1/news', $this->getStoreRequest($user_id));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonNewsStructure);
    }

    public function test_StoreNewsAsAdmin()
    {
        Sanctum::actingAs(
            RegisteredUser::find(1)            
        );

        $user_id = 2;        
             
        $response = $this->post('api/v1/news', $this->getStoreRequest($user_id));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonNewsStructure);
    }

    private function getStoreRequest($user_id)
    {
        return [
            'data' => [
                'type' => 'News',
                'attributes' => [                       
                    'user_id' => $user_id,                        
                    'title' => 'title',                    
                    'content' => 'content'                    
                ]                        
            ]
        ];
    }
}
