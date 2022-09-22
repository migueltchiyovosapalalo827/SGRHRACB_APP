<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hablitacaos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('tipo',['militar','academica']);
            $table->string('nivel');
            $table->unsignedBigInteger('efectivo_id');
            $table->foreign('efectivo_id')->references('id')->on('efectivos');
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
        Schema::dropIfExists('hablitacaos');
    }
};
