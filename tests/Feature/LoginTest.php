<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Traits\SeedDocumentAndSessionData;


class LoginTest extends TestCase
{

    use SeedDocumentAndSessionData, withFaker;


    public function setUp(): void
    {
        parent::setUp();
        $this->seedDocumentAndSessionData();

        $this->base_endpoint = route('api.login');

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */

    public function a_user_can_login()
    {
        
        $data = [
            'email' => 'secretaria@smartvote.com',
            'password' => 'senha123'
        ];
        
        $user = User::where('email', $data['email'])->first();

        $response = $this->post('api/login', $data);
        $this->assertArrayHasKey('access_token' , $response);
        $this->assertArrayHasKey('token_type', $response);
        $this->assertArrayHasKey('expires_in' , $response);
        $this->assertArrayHasKey('user' , $response);
        $this->assertEquals($user->toArray() , $response['user']);

        $response->assertStatus(200);

    }

    
}
