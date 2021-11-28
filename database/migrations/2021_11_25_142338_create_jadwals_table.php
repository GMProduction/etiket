<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kapal')->unsigned()->nullable(true);
            $table->foreign('id_kapal')->references('id')->on('master_kapals');
            $table->string('hari');
            $table->time('jam');
            $table->bigInteger('id_asal')->unsigned()->nullable(true);
            $table->foreign('id_asal')->references('id')->on('pelabuhans');
            $table->bigInteger('id_tujuan')->unsigned()->nullable(true);
            $table->foreign('id_tujuan')->references('id')->on('pelabuhans');
            $table->integer('harga');
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
        Schema::dropIfExists('jadwals');
    }
}
