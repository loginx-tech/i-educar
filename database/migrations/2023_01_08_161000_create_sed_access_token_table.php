<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sed_access_token', function (Blueprint $table) {
            $table->id();
            $table->string('token', 500);
            $table->timestamps();
        });
        DB::insert('INSERT INTO sed_access_token (token, created_at, updated_at) VALUES (?, ?, ?)', [
            123456789,
            now(),
            now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sed_access_token');
    }
};
