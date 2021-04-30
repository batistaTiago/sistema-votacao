<?php

namespace Tests\Unit;

use App\Exceptions\AppBaseException;
use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\Session;
use App\Models\SessionStatus;
use Carbon\Carbon;
use Tests\TestCase;

class SessionTest extends TestCase
{
    /** @test */
    public function basic_open_session()
    {
        $session = factory(Session::class)->create();

        $this->assertEquals(SessionStatus::SESSION_STATUS_AGUARDANDO_VOTACAO, $session->session_status_id);

        $datetime = now();
        $session->openForVotes();

        $this->assertNotNull($session->datetime_start);

        $this->assertEquals($datetime->toDateString(), Carbon::parse($session->datetime_start)->toDateString());
        $this->assertEquals(SessionStatus::SESSION_STATUS_EM_VOTACAO, $session->session_status_id);
    }

    /** @test */
    public function session_opening()
    {
        $session = factory(Session::class)->create();

        $this->assertEquals(SessionStatus::SESSION_STATUS_AGUARDANDO_VOTACAO, $session->session_status_id);

        $datetime = now();
        $session->openForVotes();

        $this->assertNotNull($session->datetime_start);

        $this->assertEquals($datetime->toDateString(), Carbon::parse($session->datetime_start)->toDateString());
        $this->assertEquals(SessionStatus::SESSION_STATUS_EM_VOTACAO, $session->session_status_id);
    }

    /** @test */
    public function sessions_under_voting_cannot_be_reopened()
    {
        $session = factory(Session::class)->create([
            'session_status_id' => SessionStatus::SESSION_STATUS_EM_VOTACAO,
        ]);

        $this->expectException(AppBaseException::class);
        $session->openForVotes();
    }

    /** @test */
    public function finished_sessions_cannot_be_reopened()
    {
        $session = factory(Session::class)->create([
            'session_status_id' => SessionStatus::SESSION_STATUS_CONCLUIDA,
        ]);

        $this->expectException(AppBaseException::class);
        $session->openForVotes();
    }

    /** @test */
    public function a_session_can_open_documents_for_voting()
    {
        $session = factory(Session::class)->create();
        $document = factory(Document::class)->create();

        // outros testes ja cobrem esse metodo, pode-se assumir que esta funcionando
        $document->attachToSession($session); 

        // outros testes ja cobrem esse metodo, pode-se assumir que esta funcionando
        $session->openForVotes();

        $session->openDocumentForVoting($document);

        $this->assertEquals(DocumentStatus::DOC_STATUS_EM_VOTACAO, $document->document_status_id);
    }

    /** @test */
    public function basic_close_session()
    {
        $session = factory(Session::class)->create([
            'session_status_id' => SessionStatus::SESSION_STATUS_EM_VOTACAO
        ]);

        $session->closeVotes();

        $this->assertNotNull($session->datetime_end);
        $this->assertEquals(SessionStatus::SESSION_STATUS_CONCLUIDA, $session->session_status_id);
    }
}
