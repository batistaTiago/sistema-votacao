<?php

namespace App\Models;

use App\Exceptions\AppBaseException;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public const AVAILABLE_FILTERS = [
        'session_status_id' => '=',
        'id' => '=', 
        'session_category_id' => '=',
        'datetime_start' => '>=',
        'datetime_end' => '<=',
    ];

    public function session_status()
    {
        return $this->belongsTo(SessionStatus::class);
    }

    /* relacionamentos */
    public function documents()
    {
        return $this->belongsToMany(Document::class, DocumentSession::class)->distinct();
    }

    /* @TODO: subir para a super classe? */
    public static function findWithFilters(array $filters)
    {
        $query = self::query();

        foreach ($filters as $key => $value) {
            if (array_key_exists($key, self::AVAILABLE_FILTERS)) {
                $operator = self::AVAILABLE_FILTERS[$key];
                $query->where($key, $operator, $value);
            }
        }

        return $query->get();
    }

    public function attachDocument(Document $document) {
        return DocumentSession::attachDocumentToSession($document, $this);
    }

    public function detachDocument(Document $document) {
        return DocumentSession::detachDocumentFromSession($document, $this);
    }

    public function openForVotes()
    {
        if ($this->session_status_id != SessionStatus::SESSION_STATUS_AGUARDANDO_VOTACAO) {
            throw new AppBaseException('A sessão não está aguardando abertura de votos.');
        }

        $this->datetime_start = now();
        $this->session_status_id = SessionStatus::SESSION_STATUS_EM_VOTACAO;
        $this->save();
    }

    public function closeVotes()
    {
        if ($this->session_status_id != SessionStatus::SESSION_STATUS_EM_VOTACAO) {
            throw new AppBaseException('A sessão não pode está aberta para votação.');
        }

        $this->datetime_end = now();
        $this->session_status_id = SessionStatus::SESSION_STATUS_CONCLUIDA;
        $this->save();
    }


    public function openDocumentForVoting(Document $document)
    {

        if ($this->session_status_id != SessionStatus::SESSION_STATUS_EM_VOTACAO) {
            throw new AppBaseException('Um documento só pode ter sua votação iniciada em uma sessao que já foi iniciada');
        }

        if ($document->document_status_id != DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO) {
            throw new AppBaseException('O documento não está aguardando votação, portanto, ele não pode ser aberto para votação agora');
        }

        $document->document_status_id = DocumentStatus::DOC_STATUS_EM_VOTACAO;
        $document->save();
    }
}
