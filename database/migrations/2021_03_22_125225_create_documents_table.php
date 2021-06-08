<?php

use App\Models\DocumentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->string('protocol_number');
            
            $table->string('attachment');
            $table->boolean('votes_are_secret')->nullable();
            
            $table->unsignedBigInteger('document_category_id');
            $table->foreign('document_category_id')->references('id')->on('document_categories');

            $table->unsignedBigInteger('document_status_id')->default(DocumentStatus::DOC_STATUS_CRIADO);
            $table->foreign('document_status_id')->references('id')->on('document_statuses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
