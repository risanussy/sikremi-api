<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_foto', function (Blueprint $table) {
            $table->index('survey_id');
            $table->foreignId('survey_id')->references('id')->on('survey')->unsigned();

            $table->text('keterangan');
            $table->text('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_foto');
    }
}
