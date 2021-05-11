<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocumentStatus;
use Illuminate\Http\Request;

class DocumentStatusController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => DocumentStatus::all(),
        ]);
    }
}
