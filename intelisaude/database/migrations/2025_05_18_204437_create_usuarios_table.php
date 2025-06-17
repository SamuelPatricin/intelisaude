<?php

use Illuminate\Database\Migrations\Migration; // importa migration, pro laravel saber que é uma migration
use Illuminate\Database\Schema\Blueprint; // importa classe que desenha a tabela e regras
use Illuminate\Support\Facades\Schema; // comando do laravel que lida com bd

return new class extends Migration // classe que herda migration
{
    // metodo pra criar
    public function up(): void
    {
       Schema::create('usuarios', function (Blueprint $table) { // cria tabela
    $table->id(); // cria id auto increment
    $table->string('nome'); // nome do usuario
    $table->string('email')->unique(); // email
    $table->string('senha'); // senha
    $table->string('codigo_verificacao')->nullable(); // cod de verificacao (pode ser nulo)
    $table->boolean('verificado')->default(false); // verifica se o email foi confirmado, 0 pra falso, 1 pra verdadeiro
    $table->timestamps(); // laravel guarda automaticamente, quando foi criado, e ultima vez que foi atualizado
});
    }

    // apagar ou desfazer up
    public function down(): void
    {
        Schema::dropIfExists('usuarios'); // apaga a tabela se ja existir
    }
};
