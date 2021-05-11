<?php

namespace Tests\Feature;

use App\Models\DocumentStatus;
use App\Models\SessionStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentAndSessionStatusAPITest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function get_all_document_status()
    {
        $response = $this->get(route('api.document-statuses'));

        $json = $response->decodeResponseJson();
        $this->assertIsArray($json);
        $this->assertIsArray($json['data']);
        $this->assertCount(DocumentStatus::count(), $json['data']);

        $response->assertStatus(200);
    }

    /** @test */
    public function get_all_session_status()
    {
        factory(SessionStatus::class, 50)->create();
        $response = $this->get(route('api.session-statuses'));

        $json = $response->decodeResponseJson();
        $this->assertIsArray($json);
        $this->assertIsArray($json['data']);
        $this->assertCount(SessionStatus::count(), $json['data']);

        $response->assertStatus(200);
    }
}
