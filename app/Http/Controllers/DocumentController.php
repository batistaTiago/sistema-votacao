<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\Session;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function index(Request $request)
    {
        $documents = Document::findWithFilters($request->all());
        return response()->json([
            'sucesso' => true,
            'data' => $documents
        ]);
    }

    public function store(CreateDocumentRequest $request)
    {

        $file = $request->file('attachment');

        $attachment = Document::storeFile($file);

        $session = Session::find($request->session_id)->first();

        $document = Document::create(array_merge($request->validated(), compact('attachment')));

        DocumentSession::create([
            'session_id' => $session->id,
            'document_id' => $document->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $document,
        ]);
    }
}
