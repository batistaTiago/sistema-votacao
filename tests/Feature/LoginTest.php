<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class LoginTest extends TestCase
{

    use withFaker;


    public function setUp(): void
    {
        parent::setUp();

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
        
        $password = $this->faker->sentence(3);
        $user = factory(User::class)->create([
            'password' => Hash::make($password)
        ]);

        $data = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->post('api/login', $data);
        $this->assertArrayHasKey('access_token' , $response);
        $this->assertArrayHasKey('token_type', $response);
        $this->assertArrayHasKey('expires_in' , $response);
        $this->assertArrayHasKey('user' , $response);
        $this->assertEquals($user->toArray() , $response['user']);

        $response->assertStatus(200);

    }

    
}
