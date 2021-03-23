<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\SeedDocumentAndSessionData;

class RetrieveDocumentTest extends TestCase
{
    use SeedDocumentAndSessionData;

    public function setUp(): void
    {
        parent::setUp();
        $this->seedDocumentAndSessionData();

        $this->base_endpoint = route('api.documents.index');

    }

    /** @test */
    public function get_documents_from_session()
    {

        $session_id = 1;
        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('session_id'));

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals(2, count($response_data['data']));
    }

    /** @test */
    public function get_documents_from_session_by_category()
    {

        $session_id = 2;
        $document_category_id = 2;
        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('session_id', 'document_category_id'));

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals(1, count($response_data['data']));
    }

    /** @test */
    public function get_documents_from_session_by_status()
    {

        $session_id = 2;
        $document_status_id = 2;
        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('session_id', 'document_status_id'));

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals(3, count($response_data['data']));
    }

    // /** @test */
    // public function get_session_by_datetime()
    // {

    //     $datetime_start = now()->subMonths(51)->toDateString();
    //     $datetime_end = now()->toDateString();

    //     $endpoint = $this->base_endpoint . '?' . http_build_query(compact('datetime_start', 'datetime_end'));

    //     $response = $this->get($endpoint, $this->headers);
    //     $response->assertStatus(200);

    //     $response_data = $response->decodeResponseJson();

    //     $expected_count = Session::where('datetime_start', '>=', $datetime_start)
    //         ->where('datetime_end', '<=', $datetime_end)
    //         ->count();

    //     $this->assertIsArray($response_data, 'data');
    //     $this->assertEquals($expected_count, count($response_data['data']));
    // }

    // /** @test */
    // public function get_session_datetime_start_is_optional()
    // {

    //     $datetime_end = now()->subDays(10)->toDateString();

    //     $endpoint = $this->base_endpoint . '?' . http_build_query(compact('datetime_end'));

    //     $response = $this->get($endpoint, $this->headers);
    //     $response->assertStatus(200);

    //     $response_data = $response->decodeResponseJson();

    //     $expected_count = Session::where('datetime_end', '<=', $datetime_end)
    //         ->count();

    //     $this->assertIsArray($response_data, 'data');
    //     $this->assertEquals($expected_count, count($response_data['data']));

    // }

    // /** @test */
    // public function get_session_datetime_end_is_optional()
    // {

    //     $datetime_start = now()->subMonths(51)->toDateString();

    //     $endpoint = $this->base_endpoint . '?' . http_build_query(compact('datetime_start'));

    //     $response = $this->get($endpoint, $this->headers);
    //     $response->assertStatus(200);

    //     $response_data = $response->decodeResponseJson();

    //     $expected_count = Session::where('datetime_start', '>=', $datetime_start)
    //         ->count();

    //     $this->assertIsArray($response_data, 'data');
    //     $this->assertEquals($expected_count, count($response_data['data']));
    // }
}
