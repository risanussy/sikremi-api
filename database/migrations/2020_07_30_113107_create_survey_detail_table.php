<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_detail', function (Blueprint $table) {
            $table->index('survey_id');
            $table->foreignId('survey_id')->references('id')->on('survey')->unsigned();

            $table->text('deskripsi_survey');
            $table->enum('check', ['Y', 'T'])->default('T');
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_detail');
    }
}
