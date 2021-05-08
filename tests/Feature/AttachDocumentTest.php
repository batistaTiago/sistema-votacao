<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttachDocumentTest extends TestCase
{

    use RefreshDatabase;

    /** @test*/
    public function a_test_can_be_attached_to_session_via_api()
    {
        $session = factory(Session::class)->create();
        $document = factory(Document::class)->create();

        $session_id = $session->id;
        $document_id = $document->id;

        $this->assertEmpty($session->fresh()->documents);
        $this->assertEmpty($document->fresh()->sessions);

        $post_data = compact('session_id', 'document_id');
        $response = $this->post(route('api.documents.attach'), $post_data);

        $this->assertEquals(1, DocumentSession::count());
        $response->assertStatus(200);
    }
}
