<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLicitacionAddColumnEstado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licitacion', function (Blueprint $table) {
            $table->string("estado",50)->after("area")->default("pendiente");
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
            $table->dropColumn("estado");
        });
    }
}
