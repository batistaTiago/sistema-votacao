<?php

namespace Tests\Unit;

use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\Session;
use Tests\TestCase;

class AttachDocumentSessionTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->document = factory(Document::class)->create();
        $this->session = factory(Session::class)->create();

        // document is created with no session
        $this->assertEquals(0, $this->document->sessions->count());
        $this->assertEquals(0, $this->session->documents->count());
    }

    /** @test */
    public function a_document_can_be_added_to_a_session()
    {
        $this->attachDocumentAndReload();
        $this->assertEquals(1, $this->document->sessions->count());
        $this->assertEquals(1, $this->session->documents->count());
    }

    /** @test */
    public function a_document_can_be_added_to_a_session_many_times()
    {
        $this->attachDocumentAndReload(2);

        $this->assertEquals(2, $this->document->sessions->count());
        $this->assertEquals(1, $this->session->documents->count());
    }

    /** @test */
    // public function attaching_a_document_to_a_session_requires_document_to_be_()
    // {
    //     $this->attachDocumentAndReload();
    //     $this->assertEquals(DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO, $this->document->document_status_id);
    // }

    /** @test */
    public function attaching_a_document_to_a_session_changes_its_status_to_waiting_votes()
    {
        $this->attachDocumentAndReload();
        $this->assertEquals(DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO, $this->document->document_status_id);
    }

    /**
     * HELPERS
     * */
    private function attachDocumentAndReload($count = 1)
    {

        for ($i = 0; $i < $count; $i++) {
            $this->session->attachDocument($this->document);
        }

        $this->document = $this->document->fresh()->load('sessions');
        $this->session = $this->session->fresh()->load('documents');
    }
}
