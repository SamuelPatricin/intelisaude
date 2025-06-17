<?php

use Illuminate\Database\Migrations\Migration;  // importa migration, pro laravel saber que é uma migration
use Illuminate\Database\Schema\Blueprint; // importa classe que desenha a tabela e regras
use Illuminate\Support\Facades\Schema; // comando do laravel que lida com bd

class AddTokenApagarToUsuariosTable extends Migration // AddTokenApagarToUsuariosTable herda o migration
{

    // metodo pra criar
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) { // edita tabela
            $table->string('token_apagar', 64)->nullable()->after('token_senha'); // cria coluna token_apagar depois de token_senha
        });
    }

     // desfazer ou apagar
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) { // edita tabela
            $table->dropColumn('token_apagar'); // remove senha_temp e token
        });
    }
}