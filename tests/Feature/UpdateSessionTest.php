<?php 


namespace Tests\Feature;

use App\Models\Session;
use App\Models\SessionStatus;

use Tests\TestCase;


class UpdateSessionTest extends TestCase
{
    
    /** @test */
    public function a_session_can_have_status_changed()
    {

        $sessionBefore = factory(Session::class)->create();

        $requestBody = [
            'session_id' => $sessionBefore->id,
            'session_status_id' => rand(1,SessionStatus::all()->count()),
        ];

        while($requestBody['session_status_id'] === $sessionBefore->session_status_id)
        {
            $requestBody['session_status_id'] = rand(1, SessionStatus::all()->count());
        }

        $response = $this->post(route('api.session.change-status'), $requestBody);

        $response->assertStatus(200);

        $sessionAfter = $response['data'];

        $this->assertNotEquals($sessionBefore->session_status_id, $sessionAfter['session_status_id']);

        $this->assertEquals($sessionBefore->id , $sessionAfter['id']);

    }
}