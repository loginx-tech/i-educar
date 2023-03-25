
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmieducar.turma_sed', function (Blueprint $table) {
            $table->id();
            //$table->foreign('cod_turma_id')->references('cod_turma')->on('pmieducar.turma')->cascadeOnDelete();
            $table->integer('cod_turma_id');
            $table->integer('cod_sed')->nullable();
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
        Schema::dropIfExists('pmieducar.turma_sed');

    }
};
