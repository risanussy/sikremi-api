<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasangan', function (Blueprint $table) {
            $table->index('aplikasi_id');
            $table->foreignId('aplikasi_id')->references('id')->on('aplikasi')->unsigned();

            $table->string('nama_lengkap', 50)->nullable();
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('pendidikan_terakhir', ['', 'Tidak Tamat SD', 'SD', 'SMP', 'SMA', 'Diploma', 'Sarjana'])->default('');
            $table->string('no_ktp', 20)->nullable();
            $table->string('pekerjaan', 30)->nullable();
            $table->double('penghasilan', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasangan');
    }
}
