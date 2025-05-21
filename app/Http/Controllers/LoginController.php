<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //  importa a classe que encapsula os dados do request
use App\Models\Usuario; // importa usuario
use Illuminate\Support\Facades\Hash; // verificar senha correta
use Illuminate\Support\Facades\Auth; // usado pra fazer login e logout no laravel

class LoginController extends Controller
{

    // mostra a página ao usuario
    public function showLoginForm()
    {
        // retorna view login.blade.php
        return view('login');
    }

    // processa o login
    public function login(Request $request)
    {
        // verifica se o email e a senha foram preenchidos corretamente
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // busca o usuario no bd, pelo email
        $usuario = Usuario::where('email', $request->email)->first();

        // se nao encontrar ou hash da senha nao confere, retorna erro
        if (!$usuario || !\Hash::check($request->senha, $usuario->senha)) {
            return back()->with('erro', 'E-mail ou senha inválidos.');
        }

        // se o usuario nao for verificado, retorna erro
        if (!$usuario->verificado) {
            return back()->with('erro', 'Conta ainda não verificada.');
        }

        // se tudo estiver ok, faz login
        Auth::login($usuario); // 

        // manda pra home
        return redirect('/homePage');
    }


    // desloga o usuario
   public function logout(Request $request)
{
    // tira o login
    Auth::logout();
    // invalida a sessao
    $request->session()->invalidate();
    // gera um novo token csrf
    $request->session()->regenerateToken();
    
    // volta pra tela de login
    return redirect('/login');
}
}
