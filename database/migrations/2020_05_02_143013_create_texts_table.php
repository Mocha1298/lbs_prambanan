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
            $table->integer('status');
            $table->string('nama');
            $table->string('keterangan');
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('bujur');
            $table->string('lintang');
            $table->integer('id_tul')->nullable();
            $table->integer('users_id')->unsigned();
            $table->integer('maps_id')->unsigned()->nullable();
            $table->integer('photos_id')->unsigned()->nullable();
            $table->integer('villages_id')->unsigned()->nullable();
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
