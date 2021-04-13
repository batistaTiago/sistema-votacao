<?php

use App\Models\DocumentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->timestamps();
        });

        DocumentStatus::insert([
            [
                'id' => DocumentStatus::DOC_STATUS_CRIADO,
                'name' => 'Aguardando votacao',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO,
                'name' => 'Aguardando votacao',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_EM_VOTACAO,
                'name' => 'Em votacao',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_VISTA,
                'name' => 'Em vista',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_VOTACAO_CONCLUIDA,
                'name' => 'Votacao Concluida',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_statuses');
    }
}
