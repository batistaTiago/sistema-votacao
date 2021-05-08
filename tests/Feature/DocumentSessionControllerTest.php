<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentSessionControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test*/
    public function it_can_attach_documents_to_sessions()
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

    /** @test*/
    public function it_can_detach_documents_and_sessions()
    {

        $session = factory(Session::class)->create();
        $document = factory(Document::class)->create();
        $session->attachDocument($document);

        $this->assertEquals(1, DocumentSession::count());

        $session_id = $session->id;
        $document_id = $document->id;

        $post_data = compact('session_id', 'document_id');
        $response = $this->post(route('api.documents.detach'), $post_data);

        $this->assertEquals(0, DocumentSession::count());
        $response->assertStatus(200);
    }
}
