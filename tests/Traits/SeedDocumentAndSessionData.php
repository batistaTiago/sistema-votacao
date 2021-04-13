<?php

namespace Tests\Traits;

use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\DocumentStatus;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait SeedDocumentAndSessionData
{

    public function seedDocumentAndSessionData()
    {
        User::insert([

            [
                'name' => 'secretaria',
                'email' => 'secretaria@smartvote.com',
                'password' => Hash::make('senha123')
            ],
            [
                'name' => 'deputado',
                'email' => 'deputado@smartvote.com',
                'password' => Hash::make('senha123')
            ],
            [
                'name' => 'vereador',
                'email' => 'vereador@smartvote.com',
                'password' => Hash::make('senha123')
            ],
            [
                'name' => 'presidente',
                'email' => 'presidente@smartvote.com',
                'password' => Hash::make('senha123')
            ],
            [
                'name' => 'admin',
                'email' => 'admin@smartvote.com',
                'password' => Hash::make('senha123')
            ],
        ]);

        Session::insert([
            [
                'name' => 'Votacao em aberto',
                'datetime_start' => null,
                'datetime_end' => null,
                'session_status_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Votacao em aberto',
                'datetime_start' => null,
                'datetime_end' => null,
                'session_status_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Votacao em andamento',
                'datetime_start' => now()->subDays(7),
                'datetime_end' => null,
                'session_status_id' => 2,
                'user_id' => 1,
            ],
            [
                'name' => 'Vontacao encerrada',
                'datetime_start' => now()->subMonths(50),
                'datetime_end' => now()->subMonths(48),
                'session_status_id' => 3,
                'user_id' => 1,
            ],
        ]);

        Document::insert([
            [
                'name' => 'Projeto de lei 420/1620',
                'attachment' => 'http://test.url/test.pdf',
                'document_category_id' => 1,
                'document_status_id' => DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO,
                // session 1
            ],
            [
                'name' => 'Projeto de lei 420/1620',
                'attachment' => 'http://test.url/test.pdf',
                'document_category_id' => 1,
                'document_status_id' => DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO,
                // session 2
            ],
            [
                'name' => 'Projeto de lei 420/1620',
                'attachment' => 'http://test.url/test.pdf',
                'document_category_id' => 1,
                'document_status_id' => DocumentStatus::DOC_STATUS_EM_VOTACAO,
                // session 2
            ],
            [
                'name' => 'Projeto de lei 420/1620',
                'attachment' => 'http://test.url/test.pdf',
                'document_category_id' => 1,
                'document_status_id' => DocumentStatus::DOC_STATUS_EM_VOTACAO,
                // session 2
            ],
            [
                'name' => 'Projeto de lei 420/1620',
                'attachment' => 'http://test.url/test.pdf',
                'document_category_id' => 2,
                'document_status_id' => DocumentStatus::DOC_STATUS_EM_VOTACAO,
                // session 2
            ],
        ]);

        DocumentSession::insert([
            [
                'session_id' => 1,
                'document_id' => 1,
            ],
            [
                'session_id' => 1,
                'document_id' => 2,
            ],
            [
                'session_id' => 2,
                'document_id' => 2,
            ],
            [
                'session_id' => 3,
                'document_id' => 2,
            ],
            [
                'session_id' => 2,
                'document_id' => 3,
            ],
            [
                'session_id' => 2,
                'document_id' => 4,
            ],
            [
                'session_id' => 2,
                'document_id' => 5,
            ],
        ]);
    }
}
