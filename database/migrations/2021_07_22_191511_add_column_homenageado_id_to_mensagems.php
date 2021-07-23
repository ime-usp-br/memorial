<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHomenageadoIdToMensagems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mensagems', function (Blueprint $table) {
            $table->integer('homenageado_id')->unsigned();
            $table->foreign('homenageado_id')->references('id')->on('homenageados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mensagems', function (Blueprint $table) {
            //
        });
    }
}
