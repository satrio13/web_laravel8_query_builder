<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDownload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() 
    {
        Schema::create('tb_download', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_file', 100);
            $table->string('file', 100);
            $table->integer('hits');
            $table->integer('id_user');
            $table->string('is_active', 1);
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
        Schema::dropIfExists('tb_download');
    }

}