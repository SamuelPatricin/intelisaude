<?php

use Illuminate\Database\Migrations\Migration;  // importa migration, pro laravel saber que é uma migration
use Illuminate\Database\Schema\Blueprint; // importa classe que desenha a tabela e regras
use Illuminate\Support\Facades\Schema; // comando do laravel que lida com bd

class AddResetTokenToUsuariosTable extends Migration // AddResetTokenToUsuariosTable herda o migration
{

    // metodo pra criar
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) { // edita tabela usuarios
            $table->string('reset_token')->nullable()->after('senha'); // adiciona coluna reset depois da senha
            $table->timestamp('token_expira_em')->nullable()->after('reset_token'); // adiciona coluna do tipo data e hora depois do reset
        });
    }

    // metodo pra apagar ou desfazer up
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) { // edita tabela
            $table->dropColumn(['reset_token', 'token_expira_em']); // remove reset e token_expira
        });
    }
}