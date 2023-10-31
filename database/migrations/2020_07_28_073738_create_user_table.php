<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 30);
            $table->string('username', 30);
            $table->string('password', 255);
            $table->enum('level', ['ANALYST', 'MANAGER', 'ADMIN'])->default('ANALYST');
            $table->enum('active', ['Y', 'N'])->default('N');
            
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
        Schema::dropIfExists('user');
    }
}
