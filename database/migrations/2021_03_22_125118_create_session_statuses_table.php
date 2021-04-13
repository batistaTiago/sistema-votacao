<?php

use App\Models\SessionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->timestamps();
        });

        SessionStatus::insert([
            [
                'id' => SessionStatus::SESSION_STATUS_AGUARDANDO_VOTACAO,
                'name' => 'Aguardando votacao'
            ],
            [
                'id' => SessionStatus::SESSION_STATUS_EM_VOTACAO,
                'name' => 'Em votacao'
            ],
            [
                'id' => SessionStatus::SESSION_STATUS_CONCLUIDA,
                'name' => 'Concluida'
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
        Schema::dropIfExists('session_statuses');
    }
}
