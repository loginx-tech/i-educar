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
        Schema::create('sed_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255);
            $table->string('description', 500)->nullable();
            $table->string('value', 255)->nullable(); // Campo para configs que necessitam de valores a mais do que true ou false
            $table->boolean('is_enabled', 255)->default(true);
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
        Schema::dropIfExists('sed_configs');
    }
};
