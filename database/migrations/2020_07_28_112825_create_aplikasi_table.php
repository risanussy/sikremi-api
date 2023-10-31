<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAplikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('no_aplikasi', 15);
            $table->string('email', 50);

            $table->enum('angunan', ['BPKB Motor', 'BPKB Mobil', 'Surat Tanah'])->default('BPKB Motor');
            $table->double('limit_kredit', 20, 2);
            $table->double('angsuran', 20, 2);
            $table->integer('jangka_waktu')->length(2);
            $table->date('tgl_aplikasi');
            
            $table->enum('status', ['Proses', 'Terima', 'Tolak'])->default('Proses');
            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aplikasi');
    }
}
