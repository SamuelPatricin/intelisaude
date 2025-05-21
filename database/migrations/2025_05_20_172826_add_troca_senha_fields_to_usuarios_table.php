<?php

use Illuminate\Database\Migrations\Migration; // importa migration, pro laravel saber que é uma migration
use Illuminate\Database\Schema\Blueprint;  // importa classe que desenha a tabela e regras
use Illuminate\Support\Facades\Schema;  // comando do laravel que lida com bd

return new class extends Migration { // cria classe que herda o migration

    // metodo pra criar
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {  // edita tabela
            $table->string('senha_temp')->nullable(); // cria coluna (possivel nula)
            $table->string('token_senha')->nullable(); // cria coluna (possivel nula)
        });
    }

    // desfazer ou apagar
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) { // edita tabela
            $table->dropColumn(['senha_temp', 'token_senha']); // remove senha_temp e token
        });
    }
};
