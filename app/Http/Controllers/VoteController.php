<?php

namespace App\Http\Controllers;

use App\Exceptions\AppBaseException;
use App\Http\Requests\RegisterVoteRequest;
use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\Vote;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        $votes = Vote::findWithFilters($request->all());
        return response()->json([
            'sucesso' => true,
            'data' => $votes,
        ]);
    }

    public function registerVote(RegisterVoteRequest $request)
    {
        try {
            $document = Document::find($request->document_id);

            if ($document->document_status_id != DocumentStatus::DOC_STATUS_EM_VOTACAO) {
                throw new AppBaseException('O documento não está aberto para votação');
            }
    
            $vote = Vote::create([
                'session_id' => $request->session_id,
                'document_id' => $request->document_id,
                'user_id' => $request->user_id,
                'vote_category_id' => $request->vote_category_id,
            ]);
    
            return response()->json([
                'success' => true,
                'data' => $vote,
                'message' => 'Voto registrado com sucesso.',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar o voto.',
            ]);
        }
    }
}
