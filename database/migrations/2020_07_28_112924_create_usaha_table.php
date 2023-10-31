<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsahaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usaha', function (Blueprint $table) {
            $table->index('aplikasi_id');
            $table->foreignId('aplikasi_id')->references('id')->on('aplikasi')->unsigned();

            $table->date('berusaha_sejak');
            $table->string('bidang_usaha', 50);
            $table->integer('jml_karyawan')->length(11);
            
            $table->text('alamat');
            $table->string('telepon', 15)->nullable();
            $table->enum('status_kepemilikan', ['Milik Sendiri', 'Sewa/Kontrak', 'Milik Keluarga'])->default('Milik Sendiri');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usaha');
    }
}
