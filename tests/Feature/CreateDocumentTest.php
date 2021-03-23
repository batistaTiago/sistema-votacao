<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentSession;
use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentTest extends TestCase
{

    public function setUp(): void
    {

        parent::setUp();

        Storage::fake(Document::DEFAULT_DISK);
        $this->headers = [
            'accept' => 'application/json',
        ];

        $this->pdf_file = UploadedFile::fake()->create('document.pdf', 1023, 'application/pdf'); // arquivo .pdf com 1023kb
        $this->doc_file = UploadedFile::fake()->create('document.doc', 1023, 'application/msword'); // arquivo .doc com 1023kb
        $this->docx_file = UploadedFile::fake()->create('document.docx', 1023, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'); // arquivo .docx com 1023kb

        /* @TODO: melhor jeito de fazer isso? */
        $this->session_id = Session::create([
            'name' => 'abcd',
            'user_id' => 1,
        ]);
    }

    /** @test */
    public function submit_document_pdf()
    {
        $this->assertCount(0, Document::all());

        $post_data = [
            'name' => 'abcd aasesag',
            'attachment' => $this->pdf_file,
            'document_category_id' => 2,
            'document_status_id' => 1,
            'session_id' => $this->session_id,
        ];

        $response = $this
            ->post(route('api.documents.store'), $post_data, $this->headers);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());
        Storage::disk(Document::DEFAULT_DISK)->assertExists(Document::DEFAULT_SAVE_PATH . '/' . $this->pdf_file->name);

        $document = Document::first();
        $document_session = DocumentSession::where('session_id', 1)
            ->where('document_id', $document->id)
            ->first();

        $this->assertNotNull($document_session);

        $this->assertNull($document->votes_are_secret);
        $this->assertEquals(2, $document->document_category_id);
        $this->assertEquals(1, $document->document_status_id);
        $this->assertEquals('abcd aasesag', $document->name);

        $this->assertStringContainsString('http', $document->attachment); //salvou como url
        $this->assertStringContainsString('/storage/documents', $document->attachment); //salvou como url
    }

    /** @test */
    public function submit_document_doc_format()
    {
        $this->assertCount(0, Document::all());

        $post_data = [
            'name' => 'abcd aasesag',
            'attachment' => $this->doc_file,
            'document_category_id' => 2,
            'document_status_id' => 1,
            'session_id' => $this->session_id,
        ];

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

        $post_data = [
            'name' => 'abcd aasesag',
            'attachment' => $this->docx_file,
            'document_category_id' => 2,
            'document_status_id' => 1,
            'session_id' => $this->session_id,
        ];

        $response = $this
            ->post(route('api.documents.store'), $post_data, $this->headers);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());
        Storage::disk(Document::DEFAULT_DISK)->assertExists(Document::DEFAULT_SAVE_PATH . '/' . $this->docx_file->name);
    }
}
