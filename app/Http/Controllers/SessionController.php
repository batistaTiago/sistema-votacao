<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSessionRequest;
use App\Models\DocumentSession;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{


    public function index(Request $request)
    {
        $sessions = Session::findWithFilters($request->all());
        return response()->json([
            'success' => true,
            'data' => $sessions
        ]);
    }

    public function getByDocument(Request $request)
    {
        $document_sessions = DocumentSession::select('session_id')
            ->where('document_id', $request->document_id)
            ->get();

        $sessions = Session::find($document_sessions->pluck('session_id'));
        
        return response()->json([
            'success' => true,
            'data' => $sessions
        ]);
    }


    public function store(CreateSessionRequest $request)
    {
        $session = Session::create($request->validated());
        return response()->json([
            'success' => true,
            'data' => $session
        ]);
    }
}
