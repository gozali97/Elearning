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
        Schema::create('diskusi_materi', function (Blueprint $table) {
            $table->id();
            $table->integer('materi_id');
            $table->unsignedBigInteger('sender_id')->after('id');
            $table->text('isi_pesan');
            $table->enum('receiver_role', ['student', 'teacher'])->after('receiver_id');
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
        Schema::dropIfExists('diskusi_materi');
    }
};
