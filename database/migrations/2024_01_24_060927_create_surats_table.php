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
        Schema::create('surats', function (Blueprint $table) {
            $table->bigIncrements('id_surat');
            $table->integer('id_karyawan');
            $table->string('nomor_surat')->nullable();
            $table->string('keterangan')->nullable();
            $table->dateTime('tanggal_surat');
            $table->string('karyawan')->nullable();
            $table->string('departemen')->nullable();
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
        Schema::dropIfExists('surats');
    }
};
