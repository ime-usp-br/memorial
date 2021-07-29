<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DatasNullableOnHomenageadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homenageados', function (Blueprint $table) {
            $table->dateTime('data_nascimento')->nullable()->change();
            $table->dateTime('data_falecimento')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('homenageados', function (Blueprint $table) {
            //
        });
    }
}
