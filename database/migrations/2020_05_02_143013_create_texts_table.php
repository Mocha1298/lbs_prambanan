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
            $table->integer('status')->unsigned();
            $table->string('keterangan');
            $table->integer('rt')->unsigned();
            $table->integer('rw')->unsigned();
            $table->string('bujur');
            $table->string('lintang');
            $table->integer('id_tul')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->integer('maps_id')->unsigned();
            $table->integer('photos_id')->unsigned();
            $table->integer('villages_id')->unsigned();
            $table->integer('subdistrict_id')->unsigned();
            $table->timestamps();
            // Relasi
            // $table->foreign('users_id')->references('id')->on('users');
            // $table->foreign('maps_id')->references('id')->on('maps');
            // $table->foreign('photos_id')->references('id')->on('photos');
            // $table->foreign('villages_id')->references('id')->on('villages');
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
