<?php

namespace Tests\Feature;

use App\Models\Session;
use App\Models\SessionStatus;
use Tests\TestCase;

class OpenCloseSessionControllerTest extends TestCase
{
    /** @test */
    public function it_opens_sessions_for_votes()
    {
        $session = factory(Session::class)->create();

        $response = $this->post(route('api.session.open-votes'), [ 'session_id' => $session->id ]);
        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertStringContainsStringIgnoringCase('sucesso', $response_data['message']);
        $this->assertEquals(SessionStatus::SESSION_STATUS_EM_VOTACAO, $session->fresh()->session_status_id);

    }

    /** @test */
    public function it_closes_sessions_for_votes()
    {
        $session = factory(Session::class)->create([
            'session_status_id' => SessionStatus::SESSION_STATUS_EM_VOTACAO
        ]);

        $response = $this->post(route('api.session.close-votes'), [ 'session_id' => $session->id ]);
        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertStringContainsStringIgnoringCase('sucesso', $response_data['message']);
        $this->assertEquals(SessionStatus::SESSION_STATUS_CONCLUIDA, $session->fresh()->session_status_id);

    }

    /** @test */
    public function a_valid_session_id_is_required_for_opening_and_closing_votes()
    {

        $response = $this->post(route('api.session.open-votes', [ 'session_id' => 420 ]));
        $response->assertStatus(422);

        $response = $this->post(route('api.session.close-votes', [ 'session_id' => 420 ]));
        $response->assertStatus(422);
    }
}
