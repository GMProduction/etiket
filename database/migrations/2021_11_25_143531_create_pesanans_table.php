<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned()->nullable(true);
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('nama');
            $table->bigInteger('id_jadwal')->unsigned()->nullable(true);
            $table->foreign('id_jadwal')->references('id')->on('jadwals');
            $table->integer('harga');
            $table->string('kode_tiket')->default(null)->nullable(true);
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('id_pembayaran')->unsigned()->nullable(true);
            $table->foreign('id_pembayaran')->references('id')->on('pembayarans');
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
        Schema::dropIfExists('pesanans');
    }
}
