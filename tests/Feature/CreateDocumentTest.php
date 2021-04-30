<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\DocumentStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateDocumentTest extends TestCase
{

    public function setUp(): void
    {

        parent::setUp();

        Storage::fake(Document::DEFAULT_DISK);
        $this->headers = [
            // 'accept' => 'application/json', // o que espero como resposta
        ];

        $this->pdf_file = UploadedFile::fake()->create('document.pdf', 1023, 'application/pdf'); // arquivo .pdf com 1023kb
        $this->doc_file = UploadedFile::fake()->create('document.doc', 1023, 'application/msword'); // arquivo .doc com 1023kb
        $this->docx_file = UploadedFile::fake()->create('document.docx', 1023, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'); // arquivo .docx com 1023kb
    }

    /** @test */
    public function submit_document_pdf()
    {
        $this->assertCount(0, Document::all());

        $post_data = factory(Document::class)->raw();

        $response = $this
            ->post(route('api.documents.store'), $post_data, $this->headers);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());
        Storage::disk(Document::DEFAULT_DISK)->assertExists(Document::DEFAULT_SAVE_PATH . '/' . $this->pdf_file->name);

        $document = Document::first();
        $document_session = DocumentSession::where('document_id', $document->id)->first();
        

        $this->assertNull($document_session); // documento nao eh automaticamente adicionado a uma sessao

        $this->assertNull($document->votes_are_secret);
        $this->assertEquals($post_data['document_category_id'], $document->document_category_id);
        $this->assertEquals(DocumentStatus::DOC_STATUS_CRIADO, $document->document_status_id);
        $this->assertEquals($post_data['name'], $document->name);

        $this->assertStringContainsString('http', $document->attachment); //salvou como url
        $this->assertStringContainsString('/storage/documents', $document->attachment); //salvou como url
    }

    /** @test */
    public function submit_document_doc_format()
    {
        $this->assertCount(0, Document::all());

        $post_data = factory(Document::class)->raw([
            'attachment' => $this->doc_file,
        ]);

        $response = $this
            ->post(route('api.documents.store'), $post_data, $this->headers);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());
        Storage::disk(Document::DEFAULT_DISK)->assertExists(Document::DEFAULT_SAVE_PATH . '/' . $this->doc_file->name);
    }

    /** @test */
    public function submit_document_docx_format()
    {
        $this->assertCount(0, Document::all());

        $post_data = factory(Document::class)->raw([
            'attachment' => $this->docx_file,
        ]);

        $response = $this
            ->post(route('api.documents.store'), $post_data, $this->headers);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());
        Storage::disk(Document::DEFAULT_DISK)->assertExists(Document::DEFAULT_SAVE_PATH . '/' . $this->docx_file->name);
    }
}
