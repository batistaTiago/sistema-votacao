<?php

namespace Tests\Feature;

use App\Exceptions\AppBaseException;
use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\Session;
use Tests\TestCase;

class DeleteDocumentTest extends TestCase
{
    /** @test */
    public function base_delete_document()
    {

        $document = factory(Document::class)->create();
        
        $response = $this->delete(route('api.documents.delete'), [
            'document_id' => $document->id
        ]);

        $response->assertStatus(200);

        $this->assertCount(0, Document::all());
    }

    /** @test */
    public function deleting_a_document_removes_it_from_all_sessions_it_is_attached_to()
    {

        $document = factory(Document::class)->create();
        $sessions = factory(Session::class, 5)->create();

        foreach ($sessions as $s) {
            $s->attachDocument($document);
        }
        
        $response = $this->delete(route('api.documents.delete'), [
            'document_id' => $document->id
        ]);

        $response->assertStatus(200);

        $this->assertCount(0, Document::all());
    }

    /** @test */
    public function deleting_a_document_requires_document_id()
    {
        factory(Document::class)->create();
        
        $response = $this->delete(route('api.documents.delete'), []);

        $response->assertStatus(422);

        $this->assertCount(1, Document::all());
    }

    /** @test */
    public function documents_cannot_be_deleted_if_they_have_been_already_voted()
    {

        $document = factory(Document::class)->create([
            'document_status_id' => DocumentStatus::DOC_STATUS_VOTACAO_CONCLUIDA
        ]);
        
        $response = $this->delete(route('api.documents.delete'), [
            'document_id' => $document->id
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());
    }
}
