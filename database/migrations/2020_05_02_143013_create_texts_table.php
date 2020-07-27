<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status');//0. ditolak, 1. diterima, 2. disetujui(survey), 3. valid
            $table->integer('readed')->nullable();
            $table->string('nama');
            $table->string('keterangan');
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('bujur');
            $table->string('lintang');
            $table->integer('id_tul')->nullable();
            $table->integer('users_id');
            $table->integer('maps_id')->nullable();
            $table->integer('photos_id')->nullable();
            $table->integer('villages_id')->nullable();
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
        Schema::dropIfExists('texts');
    }
}
