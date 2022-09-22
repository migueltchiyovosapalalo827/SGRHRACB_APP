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
    {   /* 'nome','nip','numero_do_bi','data_de_emissao','data_de_nascimento','data_de_incorporacao'
        ,'genero'  ,'iban','fliacao','fps','quadro_especial_id','unidade_id','subcategoria_id'*/
        Schema::create('efectivos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nip')->unique();
            $table->string('numero_do_bi')->unique();
            $table->date('data_de_emissao');
            $table->date('data_de_nascimento');
            $table->date('data_de_incorporacao');
            $table->string('genero');
            $table->string('iban')->unique();
            $table->string('fliacao');
            $table->enum('fps',['QUADRO PERMANENTE','SERVICO MILITAR DE CONTARTO (QUADRO MILICIANO)','SERVIÇO MILITAR OBRIGATORIO', 'TRABALHADORES CIVIS']);
            $table->unsignedBigInteger('quadro_especial_id');
            $table->foreign('quadro_especial_id')->references('id')->on('quadro_especials');
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->unsignedBigInteger('subcategoria_id');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias');
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
        Schema::dropIfExists('efectivos');
    }
};
