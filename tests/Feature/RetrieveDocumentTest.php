<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\Session;
use Tests\TestCase;

class RetrieveDocumentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->base_endpoint = route('api.documents.index');
    }

    /** @test */
    public function get_documents_from_session()
    {

        $expected_count = 2;

        $session = factory(Session::class)->create();
        $documents = factory(Document::class, $expected_count)->create();

        foreach ($documents as $d) {
            $session->attachDocument($d);
        }

        $session_id = $session->id;
        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('session_id'));

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals($expected_count, count($response_data['data']));
    }

    /** @test */
    public function get_documents_from_session_by_category()
    {
        $expected_count = 1;
        $create_count = 4;

        $session = factory(Session::class)->create();
        $documents = factory(Document::class, $create_count)->create();

        foreach ($documents as $d) {
            $session->attachDocument($d);
        }

        $session_id = $session->id;
        $document_category_id = $documents->first()->document_category_id;

        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('session_id', 'document_category_id'));

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals($expected_count, count($response_data['data']));
    }

    /** @test */
    public function get_documents_from_session_by_status()
    {

        $expected_count = 4;

        $session = factory(Session::class)->create();
        $documents = factory(Document::class, $expected_count)->create();
        $document = factory(Document::class)->create();
        
        foreach ($documents as $d) {
            $session->attachDocument($d);
        }

        $documents->first()->document_status_id = DocumentStatus::DOC_STATUS_EM_VOTACAO;
        $documents->first()->save();

        $session_id = $session->id;
        $document_status_id = $documents->first()->document_status_id;

        $endpoint = $this->base_endpoint . '?' . http_build_query(compact('session_id', 'document_status_id'));

        $response = $this->get($endpoint, $this->headers);

        $response->assertStatus(200);

        $response_data = $response->decodeResponseJson();

        $this->assertIsArray($response_data, 'data');
        $this->assertEquals(1, count($response_data['data']));
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
