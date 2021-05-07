<?php

namespace Tests\Unit;

use App\Exceptions\AppBaseException;
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
    public function a_document_can_be_attached_to_a_session()
    {
        $this->attachDocumentAndReload();
        $this->assertEquals(1, $this->document->sessions->count());
        $this->assertEquals(1, $this->session->documents->count());
    }

    /** @test */
    public function attaching_a_document_to_the_same_session_twice_throws_an_exception()
    {
        $this->expectException(AppBaseException::class);

        $r = rand(2, 5);
        $this->attachDocumentAndReload($r);

        $this->assertEquals(1, $this->document->sessions->count());
        $this->assertEquals(1, $this->session->documents->count());
    }

    /** @test */
    public function attaching_a_document_to_a_session_changes_its_status_to_waiting_votes()
    {
        $this->attachDocumentAndReload();
        $this->assertEquals(DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO, $this->document->document_status_id);
    }

    /** @test */
    public function an_attached_document_can_be_detached_from_its_session()
    {
        $this->attachDocumentAndReload();

        $this->document->detachFromSession($this->session);

        $this->document = $this->document->fresh();
        $this->session = $this->session->fresh();

        $this->assertEquals(0, $this->document->sessions->count());
        $this->assertEquals(0, $this->session->documents->count());
    }

    /** @test */
    public function an_attached_document_cannot_be_detached_from_its_session_if_its_not_waiting_for_votes()
    {
        $this->attachDocumentAndReload();

        $this->expectException(AppBaseException::class);

        $this->session->openForVotes();
        $this->session->openDocumentForVoting($this->document);

        $this->document->detachFromSession($this->session);

        $this->document = $this->document->fresh();
        $this->session = $this->session->fresh();

        $this->assertEquals(0, $this->document->sessions->count());
        $this->assertEquals(0, $this->session->documents->count());
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
