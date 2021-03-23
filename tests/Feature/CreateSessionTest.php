<?php

namespace Tests\Feature;

use App\Models\Session;
use Tests\TestCase;

class SessionTest extends TestCase
{

    /** @test */
    public function create_session()
    {

        $this->assertEquals(0, Session::count());

        $post_data = [
            'name' => 'TESTE ABC',
            'user_id' => 1,
        ];

        $response = $this->post(route('api.session.store'), $post_data, $this->headers);

        $response->assertStatus(200);
        $this->assertEquals(1, Session::count());

        $session = Session::first();

        $this->assertNull($session->datetime_start);
        $this->assertNull($session->datetime_end);
        $this->assertEquals(1, $session->session_status_id);
        $this->assertEquals('TESTE ABC', $session->name);

    }

    /** @test */
    public function session_name_is_required()
    {
        $this->assertEquals(0, Session::count());
        $post_data = [
            'user_id' => 1,
        ];

        $response = $this->post(route('api.session.store'), $post_data, $this->headers);

        $response->assertStatus(422);
        $this->assertEquals(0, Session::count());
        $this->assertNull(Session::first());
    }

    /** @test */
    public function user_id_is_required()
    {
        $this->assertEquals(0, Session::count());
        $post_data = [
            'name' => 'TESTE ABC',
        ];

        $response = $this->post(route('api.session.store'), $post_data, $this->headers);

        $response->assertStatus(422);
        $this->assertEquals(0, Session::count());
        $this->assertNull(Session::first());
    }
}
