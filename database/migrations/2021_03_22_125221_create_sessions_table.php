<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name'); /* talvez precise, para orgnizar */

            $table->dateTime('datetime_start')->nullable();
            $table->dateTime('datetime_end')->nullable();

            $table->unsignedBigInteger('session_status_id')->default(1);
            $table->foreign('session_status_id')->references('id')->on('session_statuses');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('sessions');
    }
}
