<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemohonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemohon', function (Blueprint $table) {
            $table->index('aplikasi_id');
            $table->foreignId('aplikasi_id')->references('id')->on('aplikasi')->unsigned();

            $table->string('nama_lengkap', 50);
            $table->string('tempat_lahir', 30);
            $table->date('tgl_lahir');
            $table->enum('pendidikan_terakhir', ['Tidak Tamat SD', 'SD', 'SMP', 'SMA', 'Diploma', 'Sarjana'])->default('SD');
            $table->string('telepon', 15);
            $table->text('alamat');
            $table->string('kecamatan', 30);
            $table->string('kota', 30);
            $table->string('provinsi', 30);
            $table->string('kode_pos', 10);

            $table->string('no_ktp', 20);
            $table->string('no_npwp', 20);

            $table->enum('status_tempat_tinggal', ['Milik Sendiri', 'Sewa/Kontrak', 'Milik Keluarga', 'Rumah Dinas'])->default('Milik Sendiri');
            $table->enum('lama_tinggal', ['<2 tahun', '>2 <5 tahun', '>5 tahun'])->default('>5 tahun');
            $table->enum('status', ['Menikah', 'Tidak Menikah', 'Janda/Duda'])->default('Menikah');

            $table->integer('jml_tanggungan')->length(2);
            $table->string('no_kk', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemohon');
    }
}
