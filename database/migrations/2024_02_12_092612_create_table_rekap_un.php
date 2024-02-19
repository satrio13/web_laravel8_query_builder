<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRekapUn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('tb_rekap_un', function (Blueprint $table) {
            $table->increments('id_un');
            $table->integer('id_kurikulum');
            $table->integer('tertinggi');
            $table->integer('terendah');
            $table->integer('rata');
            $table->integer('id_tahun');
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
        Schema::dropIfExists('tb_rekap_un');
    }

}