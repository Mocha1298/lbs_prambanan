<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('roles_id')->unsigned();
            $table->integer('aktivasi')->unsigned();
            $table->integer('rw')->unsigned();
            $table->integer('villages_id')->unsigned();
            $table->integer('subdistricts_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();
            // Relasi
            // $table->foreign('levels_id')->references('id')->on('levels');
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
        Schema::dropIfExists('users');
    }
}
