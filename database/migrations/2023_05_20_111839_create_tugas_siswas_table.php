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
        Schema::create('tugas_siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_siswa');
            $table->integer('id_mapel');
            $table->integer('tugas_1');
            $table->integer('tugas_2');
            $table->integer('tugas_3');
            $table->integer('tugas_4');
            $table->integer('tugas_5');
            $table->integer('tugas_6');
            $table->integer('tugas_7');
            $table->integer('tugas_8');
            $table->integer('tugas_9');
            $table->integer('tugas_10');
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
        Schema::dropIfExists('tugas_siswas');
    }
};
