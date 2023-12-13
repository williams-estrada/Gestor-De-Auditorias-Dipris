<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLicitacionAddDefaultCantidadAplica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licitacion', function (Blueprint $table) {
            $table->integer("cantidad_aplica")->default(0)->change();
            $table->integer("progreso_aplica")->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licitacion', function (Blueprint $table) {
            //
        });
    }
}
