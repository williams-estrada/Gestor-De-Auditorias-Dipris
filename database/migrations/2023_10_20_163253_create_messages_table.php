<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('contenido', 250);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('to_user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('usuarios')
                    ->onUpdate('cascade');
            $table->foreign('to_user_id')->references('id')->on('usuarios')
                    ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
