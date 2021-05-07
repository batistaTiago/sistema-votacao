<?php

namespace App\Models;

use App\Exceptions\AppBaseException;
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
        } catch (\Throwable $e) {
            DB::rollBack();
            
            $is_duplicate_entry_exception = (($e instanceof QueryException) and (strpos(strtolower($e->getMessage()), 'unique') !== false)); // contem string "unique"
            if ($is_duplicate_entry_exception) {
                throw new AppBaseException('O documento já está anexado a esta sessão');
            }

            throw $e;
        }
    }

    public static function detachDocumentFromSession(Document $document, Session $session)
    {
        /* regra: so pode remover da sessao se o documento estiver aberto para votacao */

        if ($document->document_status_id != DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO) {
            throw new AppBaseException('O documento não pode ser removido da sessão, pois não está aguardando votação');
        }

        return DocumentSession::where([
            'document_id' => $document->id,
            'session_id' => $session->id
        ])->delete();
    }
}
