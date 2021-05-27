<?php

namespace App\Http\Controllers;

use App\Exceptions\AppBaseException;
use App\Http\Requests\API\UpdateOrDeleteDocumentRequest;
use App\Http\Requests\CreateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\DocumentStatus;
use App\Models\Session;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function index(Request $request)
    {
        $documents = Document::findWithFilters($request->all())
        ->load('document_status');;
        return response()->json([
            'sucesso' => true,
            'data' => $documents,
        ]);
    }

    public function store(CreateDocumentRequest $request)
    {

        $attachment = $this->__storeAttachment();

        $document = Document::create(array_merge($request->validated(), compact('attachment')));

        if (isset($request->session_id)) {
            $session = Session::find($request->session_id);
            DocumentSession::attachDocumentToSession($document, $session);
        }

        return response()->json([
            'success' => true,
            'data' => $document,
        ]);
    }

    public function update(UpdateOrDeleteDocumentRequest $request)
    {
        $document = Document::find($request->document_id);
        echo ($request);
        if ($document->document_status_id == DocumentStatus::DOC_STATUS_VOTACAO_CONCLUIDA) {
            throw new AppBaseException('O documento não pode ser atualizado, pois ja foi votado');
        }

        $update_data = [
            'document_category_id' => $request->document_category_id,
            'name' => $request->name,
        ];

        if ($request->hasFile('attachment')) {
            $update_data['attachment'] =  $this->__storeAttachment();
        }

        $document->update($update_data);

        return response()->json([
            'success' => true,
            'message' => 'Documento atualizado com sucesso',
        ]);
    }

    public function delete(UpdateOrDeleteDocumentRequest $request)
    {

        $document = Document::find($request->document_id);

        if ($document->document_status_id == DocumentStatus::DOC_STATUS_VOTACAO_CONCLUIDA) {
            throw new AppBaseException('O documento não pode ser deletado, pois ja foi votado');
        }
        DocumentSession::where('document_id', $request->document_id)->delete();
        Document::where('id', $request->document_id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Documento deletado com sucesso',
        ]);
    }

    private function __storeAttachment()
    {
        $file = request()->file('attachment');
        return Document::storeFile($file);
    }
}
