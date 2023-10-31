<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->index('aplikasi_id');
            $table->foreignId('aplikasi_id')->references('id')->on('aplikasi')->unsigned();

            $table->double('penghasilan_perbulan', 15, 3);
            $table->double('biaya', 15, 3);
            $table->double('keuntungan', 15, 3);
            $table->double('penghasilan_lainnya', 15, 3);
            $table->double('total_pinjaman_lain', 15, 3);
            $table->double('angsuran_pinjaman_lain', 15, 3);
            $table->integer('sisa_waktu_angsuran')->length(11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keuangan');
    }
}
