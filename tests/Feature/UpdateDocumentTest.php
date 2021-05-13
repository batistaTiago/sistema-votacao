<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentStatus;
use App\Models\Session;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateDocumentTest extends TestCase
{
    /** @test */
    public function base_update_document()
    {

        Storage::fake(Document::DEFAULT_DISK);
        $this->pdf_file = UploadedFile::fake()->create('new_file.pdf', 1023, 'application/pdf'); // arquivo .pdf com 1023kb

        $document = factory(Document::class)->create();
        $new_category = factory(DocumentCategory::class)->create();

        $response = $this->patch(route('api.documents.update'), [
            'document_id' => $document->id,
            'name' => 'changeeeed!!',
            'document_category_id' => $new_category->id,
            'attachment' => $this->pdf_file
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());

        $document = Document::first();

        $this->assertEquals('changeeeed!!', $document->name);
        $this->assertEquals($document->document_category_id, $new_category->id);

        $this->assertStringContainsString('http', $document->attachment); //salvou como url
        $this->assertStringContainsString('/storage/documents', $document->attachment); //salvou como url
        $this->assertStringContainsString('new_file.pdf', $document->attachment); //salvou como url
        
        Storage::disk(Document::DEFAULT_DISK)->assertExists(Document::DEFAULT_SAVE_PATH . '/new_file.pdf');
    }

    /** @test */
    public function documents_cannot_be_updated_if_they_have_been_already_voted()
    {
        
        $document = factory(Document::class)->create([
            'document_status_id' => DocumentStatus::DOC_STATUS_VOTACAO_CONCLUIDA
        ]);
        
        $response = $this->patch(route('api.documents.update'), [
            'document_id' => $document->id
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, Document::all());
    }
}
