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
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->boolean('ausente');
            $table->enum('motivo',['FALTA',	'HOSPITAL',	'M/SERVIÇO','FERIAS','DISPENS',	'DOENTES','TRANSFERENCIA','DETIDOS','CURSO '])->nullable();
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
        Schema::dropIfExists('presencas');
    }
};
