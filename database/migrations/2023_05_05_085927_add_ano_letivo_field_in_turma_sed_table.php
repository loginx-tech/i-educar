<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pmieducar.turma_sed', function (Blueprint $table) {
            $table->integer('ano_letivo')->default(date('Y'))->after('cod_sed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pmieducar.turma_sed', function (Blueprint $table) {
            $table->dropColumn('ano_letivo');
        });
    }
};
