<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DocumentSession extends Model
{
    protected $guarded = [];

    public static function attachDocumentToSession(Document $document, Session $session)
    {

        try {
            DB::beginTransaction();
            $document->document_status_id = DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO;
            $document->save();

            DocumentSession::create([
                'document_id' => $document->id,
                'session_id' => $session->id,
            ]);

            DB::commit();

            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            return false;
        }
    }
}
