<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKerabatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kerabat', function (Blueprint $table) {
            $table->index('aplikasi_id');
            $table->foreignId('aplikasi_id')->references('id')->on('aplikasi')->unsigned();

            $table->string('nama_lengkap', 50);
            $table->string('hubungan', 30);
            $table->text('alamat');
            $table->string('kota', 20);
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
            
            $table->string('telepon', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kerabat');
    }
}
