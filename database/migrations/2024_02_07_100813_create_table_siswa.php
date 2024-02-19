<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up() 
    {
        Schema::create('tb_siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tahun');
            $table->integer('jml1pa');
            $table->integer('jml1pi');
            $table->integer('jml2pa');
            $table->integer('jml2pi');
            $table->integer('jml3pa');
            $table->integer('jml3pi');
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
        Schema::dropIfExists('tb_siswa');
    }

}