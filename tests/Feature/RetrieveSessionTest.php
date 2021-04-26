<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Session;
use Tests\TestCase;

class RetrieveSessionTest extends TestCase
{
    
    public function setUp(): void
    {
        parent::setUp();
        $this->base_endpoint = route('api.session.index');
    }

    /** @test */
    public function get_all_sessions()
    {

        $expected_count = 3;
        $sessions = factory(Session::class, $expected_count)->create();
        
        $endpoint = $this->base_endpoint;

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        dd($response_data);

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals(Session::count(), count($response_data['data']));
    }

    /** @test */
    public function get_session_by_status_filter()
    {

        $session_status_id = 1;

        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('session_status_id'));

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertIsArray($response_data, 'data');

        $expected_count = Session::where(compact('session_status_id'))->count();
        $this->assertEquals($expected_count, count($response_data['data']));
    }

    /** @test */
    public function get_session_by_datetime()
    {

        $datetime_start = now()->subMonths(51)->toDateString();
        $datetime_end = now()->toDateString();

        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('datetime_start', 'datetime_end'));

        $response = $this->get($endpoint, $this->headers);
        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $expected_count = Session::where('datetime_start', '>=', $datetime_start)
            ->where('datetime_end', '<=', $datetime_end)
            ->count();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals($expected_count, count($response_data['data']));
    }

    /** @test */
    public function get_session_datetime_start_is_optional()
    {

        $datetime_end = now()->subDays(10)->toDateString();

        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('datetime_end'));

        $response = $this->get($endpoint, $this->headers);
        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $expected_count = Session::where('datetime_end', '<=', $datetime_end)
            ->count();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals($expected_count, count($response_data['data']));

    }

    /** @test */
    public function get_session_datetime_end_is_optional()
    {

        $datetime_start = now()->subMonths(51)->toDateString();

        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('datetime_start'));

        $response = $this->get($endpoint, $this->headers);
        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $expected_count = Session::where('datetime_start', '>=', $datetime_start)
            ->count();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals($expected_count, count($response_data['data']));
    }

    /** @test */
    public function get_sessions_of_document()
    {
        $expected_count = 3;

        $document = factory(Document::class)->create();
        $sessions = factory(Session::class, $expected_count)->create();

        /* @TODO: ver forma melhor de fazer isso */
        foreach ($sessions as $s) {
            $s->attachDocument($document);
        }

        $document_id = $document->id;

        $endpoint = route('api.session.get-by-document') . '?' . http_build_query(compact('document_id'));

        $response = $this->get($endpoint, $this->headers);
        $response->assertStatus(200);


        $response_data = $response->decodeResponseJson();
        $this->assertIsArray($response_data, 'data');

        $this->assertEquals($expected_count, count($response_data['data']));
    }
}
