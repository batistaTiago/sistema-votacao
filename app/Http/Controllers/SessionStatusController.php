<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SessionStatus;
use Illuminate\Http\Request;

class SessionStatusController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => SessionStatus::all(),
        ]);
    }
}
