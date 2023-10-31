<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval', function (Blueprint $table) {
            $table->id();
            $table->string('no_approval', 15);

            $table->index('aplikasi_id');
            $table->foreignId('aplikasi_id')->references('id')->on('aplikasi')->unsigned();

            $table->index('user_id');
            $table->foreignId('user_id')->references('id')->on('user')->unsigned();

            $table->double('limit_approve', 20, 2);
            $table->double('angsuran_approve', 20, 2);
            $table->integer('jangka_waktu_approve')->length(2);

            $table->date('tgl_approval');
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
        Schema::dropIfExists('approval');
    }
}
