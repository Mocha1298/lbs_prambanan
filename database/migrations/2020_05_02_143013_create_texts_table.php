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
            $table->string('status');
            $table->string('keterangan');
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('bujur');
            $table->string('lintang');
            $table->integer('id_tul')->nullable();
            $table->integer('users_id')->unsigned();
            $table->integer('maps_id')->unsigned();
            $table->integer('photos_id')->unsigned();
            $table->integer('villages_id')->unsigned();
            $table->integer('subdistricts_id')->unsigned();
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
