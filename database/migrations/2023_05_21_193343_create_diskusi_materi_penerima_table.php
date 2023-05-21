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
        Schema::create('diskusi_materi_penerima', function (Blueprint $table) {
            $table->increments('id_diskusi_penerima');
            $table->unsignedBigInteger('diskusi_materi_id');
            $table->unsignedBigInteger('receiver_id');
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
        Schema::dropIfExists('diskusi_materi_penerima');
    }
};
