<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('level');
            $table->date('perbaikan')->nullable();
            $table->integer('rt');
            $table->integer('rw');
            $table->string('bujur');
            $table->string('lintang');
            $table->integer('types_id')->unsigned();
            $table->integer('villages_id')->unsigned();
            $table->integer('photos_id')->unsigned();
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
        Schema::dropIfExists('maps');
    }
}
