<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecuperacaoSenhaController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\ExameController;
use App\Http\Controllers\AutoconsultaController;


Route::get('/', function () {
    return view('cadastro');
});

Route::get('/novaSenha', function () {
    return view('novaSenha');
});

Route::get('/codigoVerificacao', [AuthController::class, 'mostrarCodigoVerificacao']);

// view tela de esqueceu senha
Route::get('/recuperacaoConta', function () {
    return view('recuperacaoConta');
});

Route::get('/homePage', function () {
    return view('homePage');
});

Route::post('/cadastro', [AuthController::class, 'register'])->name('cadastro');
Route::post('/verificar-codigo', [AuthController::class, 'verificarCodigo']);
Route::post('/reenviar-codigo', [AuthController::class, 'reenviarEmail'])->name('reenviar.email');




Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::post('/recuperacaoConta', [RecuperacaoSenhaController::class, 'enviarLink'])->name('recuperacaoConta.enviar');

Route::get('/novaSenha', [RecuperacaoSenhaController::class, 'mostrarFormularioNovaSenha'])->name('novaSenha.form');

Route::post('/novaSenha', [RecuperacaoSenhaController::class, 'atualizarSenha'])->name('novaSenha.atualizar');



Route::get('/homePage', [ContaController::class, 'conta'])->middleware('auth')->name('homePage');



Route::post('/atualizar-nome', [ContaController::class, 'atualizarNome'])->name('atualizar.nome');



Route::get('/atualizarEmail', fn() => view('atualizarEmail'))->name('email.troca.form');
Route::post('/enviar-link-troca-email', [ContaController::class, 'enviarLinkTrocaEmail'])->name('email.troca.enviar');
Route::get('/confirmar-troca-email/{token}', [ContaController::class, 'confirmarTrocaEmail'])->name('email.troca.confirmar');



Route::get('/atualizarSenha', fn() => view('atualizarSenha'))->name('senha.troca.form');
Route::post('/enviar-link-troca-senha', [ContaController::class, 'enviarLinkTrocaSenha'])->name('senha.troca.enviar');
Route::get('/confirmar-troca-senha/{token}', [ContaController::class, 'confirmarTrocaSenha'])->name('senha.troca.confirmar');



Route::get('/apagarUsuario', [ContaController::class, 'formApagarUsuario'])->name('usuario.apagar.form');

Route::get('/apagar-conta', fn() => view('apagarConta'))->name('conta.apagar.form');


Route::post('/conta/enviar-link-apagar-conta', [ContaController::class, 'enviarLinkApagarConta'])->middleware('auth');


Route::get('/confirmar-apagar-conta/{token}', [ContaController::class, 'confirmarApagarConta'])->name('conta.apagar.confirmar');



Route::post('/enviar-exame', [ExameController::class, 'enviar']);


Route::post('/autoconsulta', [AutoconsultaController::class, 'consultar'])->middleware('auth');
