<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePrestasiGuru extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
    public function up()
    {
        Schema::create('tb_prestasi_guru', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tahun');
            $table->string('nama', 100);
            $table->string('prestasi', 100);
            $table->string('nama_guru', 100);
            $table->string('tingkat', 1);
            $table->string('jenis', 1);
            $table->string('keterangan', 100)->nullable();
            $table->string('gambar', 250)->nullable();
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
        Schema::dropIfExists('tb_prestasi_guru');
    }

}