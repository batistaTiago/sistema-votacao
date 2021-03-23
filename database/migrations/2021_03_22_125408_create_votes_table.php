<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('sessions');

            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('documents');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('vote_category_id');
            $table->foreign('vote_category_id')->references('id')->on('vote_categories');

            $table->unique(['user_id', 'document_id']);

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
        Schema::dropIfExists('votes');
    }
}
