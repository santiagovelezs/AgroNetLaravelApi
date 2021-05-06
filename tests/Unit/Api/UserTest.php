<?php

namespace Tests\Unit\Api;

use App\Models\RegisteredUser;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    const jsonUserStructure = [
        'data' => [ 
            'type',
            'id',
            'attributes' => [
                'nombre',
                'apellido',
                'email',
                'departamento',
                'ciudad',
                'telefono',              
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
    public function test_UserRegistration()
    {
        $email = "user001@mail.es";       
        $response = $this->post('api/v1/users', $this->getStoreRequest($email));                     

        $response->assertStatus(201);

        $response->assertJsonStructure($this::jsonUserStructure);
    }

    public function test_UserExistsRegistration()
    {
        $email = "admin@mail.es";       
        
        $response = $this->withHeaders(['Accept' => 'aplication/json'])->post('api/v1/users', $this->getStoreRequest($email));

        $response->assertStatus(422);        
    }

    public function test_UserLogin()
    {
        $response = $this->withHeaders(['Accept' => 'aplication/json'])->post('api/v1/auth', [
            "data" => [
                "type" => "RegisteredUser",
                "attributes" => [
                    "email" => "user01@mail.es",
                    "password" => "hola123",
                    "nameToken" => "web"
                  ]
            ]
        ]);

        $response->assertStatus(200);  
    }

    public function test_UserIncorrectLogin()
    {
        $response = $this->withHeaders(['Accept' => 'aplication/json'])->post('api/v1/auth', [
            "data" => [
                "type" => "RegisteredUser",
                "attributes" => [
                    "email" => "user01@mail.es",
                    "password" => "IncorrectPassword",
                    "nameToken" => "web"
                  ]
            ]
        ]);

        $response->assertStatus(401); 
    }

    public function test_UserLogout()
    {
        Sanctum::actingAs(
            RegisteredUser::find(1)            
        );

        $response = $this->delete('api/v1/auth');

        $response->assertStatus(200); 

        $response->assertJson(['message' => 'Token revoked']);
    }
    
    public function test_getUser()
    {
        Sanctum::actingAs(
            RegisteredUser::find(3)            
        );

        $response = $this->get('api/v1/users/3');

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonUserStructure);
       
    }

    public function test_getNoAuthorizedUser()
    {
        Sanctum::actingAs(
            RegisteredUser::find(2)            
        );

        $response = $this->get('api/v1/users/3');

        $response->assertStatus(401);       
       
    }

    public function test_getUserAsAdmin()
    {
        Sanctum::actingAs(
            RegisteredUser::find(1)            
        );

        $response = $this->get('api/v1/users/3');

        $response->assertStatus(200); 

        $response->assertJsonStructure($this::jsonUserStructure);       
       
    }

    private function getStoreRequest($email)
    {
        return [
            "data" => [
                "type" => "RegisteredUser",
                "attributes" => [                            
                    "nombre" => "User",
                    "apellido" => "test",
                    "email" => $email,
                    "password"=> Hash::make('hola123'),
                    "nameToken" => "web",
                    "departamento" => "Caldas",
                    "ciudad" => "Herveo",
                    "telefono" => "3012345678"
                ]                        
            ]
        ];
    }    
    
    
}
