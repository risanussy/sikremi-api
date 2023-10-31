<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKreditDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kredit_detail', function (Blueprint $table) {
            $table->index('kredit_id');
            $table->foreignId('kredit_id')->references('id')->on('kredit')->unsigned();

            $table->integer('angsuran')->length('2');
            $table->double('cicilan', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kredit_detail');
    }
}
