<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\Session;
use Illuminate\Http\Request;

class DocumentSessionController extends Controller
{
    public function attach(Request $request)
    {
        $document = Document::find($request->document_id);
        $session = Session::find($request->session_id);

        $session->attachDocument($document);

        return response()->json([
            'success' => true,
            'message' => 'O Documento vinculado à Sessão com sucesso'
        ]);
    }

    public function detach(Request $request)
    {
        $document = Document::find($request->document_id);
        $session = Session::find($request->session_id);

        DocumentSession::detachDocumentFromSession($document, $session);

        return response()->json([
            'success' => true,
            'message' => 'O Documento desvinculado da Sessão com sucesso'
        ]);
    }
}
