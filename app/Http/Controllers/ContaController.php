<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Usuario;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContaController extends Controller
{
    public function conta()
    {
        $usuario = Auth::user(); // Pega o usuário logado
        return view('homePage', compact('usuario')); // A view deve ser resources/views/conta.blade.php
    }

    public function atualizarNome(Request $request)
    {
        $usuario = Auth::user(); // Pega diretamente o usuário autenticado

        if ($usuario) {
            $usuario->nome = $request->nome;
            $usuario->save();

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'erro'], 400);
    }



    public function enviarLinkTrocaEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $usuario = Auth::user();

        if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
            return response()->json(['erro' => 'Senha incorreta'], 401);
        }

        $novoEmail = $request->email;
        $token = bin2hex(random_bytes(32));

        $usuario->email_temp = $novoEmail;
        $usuario->token_email = $token;
        $usuario->save();

        $this->enviarEmailConfirmacao($usuario, $novoEmail, $token);

        return response()->json(['mensagem' => 'Um link de confirmação foi enviado para o novo e-mail.']);
    }

    private function enviarEmailConfirmacao($usuario, $novoEmail, $token)
    {
        $link = route('email.troca.confirmar', ['token' => $token]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($novoEmail);

            $mail->isHTML(true);
            $mail->Subject = 'InteliSaúde - Troca de e-mail';
            $mail->Body = "
                Olá, <b>{$usuario->nome}</b>.<br><br>
                <h2>Clique no link abaixo para confirmar a troca de e-mail:</h2><br><br>
                <h1><a href='{$link}'>{$link}</a></h1><br><br>
                Se você não solicitou essa alteração, ignore este e-mail.<br><br>
                <b>Obrigado,<br>InteliSaúde.</b>
            ";

            $mail->send();
        } catch (Exception $e) {
            Log::error('Erro ao enviar e-mail de troca: ' . $mail->ErrorInfo);
        }
    }

    public function confirmarTrocaEmail($token)
    {
        $usuario = Usuario::where('token_email', $token)->first();

        if (!$usuario || !$usuario->email_temp) {
            return redirect('/login')->with('erro', 'Token inválido ou expirado.');
        }

        $usuario->email = $usuario->email_temp;
        $usuario->email_temp = null;
        $usuario->token_email = null;
        $usuario->save();

        return redirect('/homePage')->with('mensagem', 'E-mail alterado com sucesso!');
    }



    public function enviarLinkTrocaSenha(Request $request)
    {
        $request->validate([
            'senha' => 'required',
            'senha_nova' => 'required|min:6',
        ]);

        $usuario = Auth::user();

        if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
            return response()->json(['erro' => 'Senha incorreta'], 401);
        }

        $senhaNovaHash = Hash::make($request->senha_nova);
        $token = bin2hex(random_bytes(32));

        $usuario->senha_temp = $senhaNovaHash;
        $usuario->token_senha = $token;
        $usuario->save();

        $this->enviarEmailConfirmacaoSenha($usuario, $token);

        return response()->json(['status' => 'ok']);
    }

    private function enviarEmailConfirmacaoSenha($usuario, $token)
    {
        $link = route('senha.troca.confirmar', ['token' => $token]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($usuario->email);

            $mail->isHTML(true);
            $mail->Subject = 'InteliSaúde - Troca de senha';
            $mail->Body = "
            Olá, <b>{$usuario->nome}</b>.<br><br>
            <h2>Clique no link abaixo para confirmar a troca de senha:</h2><br><br>
            <h1><a href='{$link}'>{$link}</a></h1><br><br>
            Se você não solicitou essa alteração, ignore este e-mail.<br><br>
            <b>Obrigado,<br>InteliSaúde.</b>
        ";

            $mail->send();
        } catch (Exception $e) {
            Log::error('Erro ao enviar e-mail de troca: ' . $mail->ErrorInfo);
            Log::info('Exceção: ' . $e->getMessage());
        }
    }

    public function confirmarTrocaSenha($token)
    {
        $usuario = Usuario::where('token_senha', $token)->first();

        if (!$usuario || !$usuario->senha_temp) {
            return redirect('/login')->with('erro', 'Token inválido ou expirado.');
        }

        $usuario->senha = $usuario->senha_temp;
        $usuario->senha_temp = null;
        $usuario->token_senha = null;
        $usuario->save();

        return redirect('/homePage')->with('mensagem', 'Senha alterada com sucesso!');
    }



    public function formApagarUsuario()
{
    return view('apagarUsuario'); // Certifique-se que a view está em resources/views/apagarUsuario.blade.php
}

    public function enviarLinkApagarConta(Request $request)
    {
        $request->validate([
            'senha' => 'required',
        ]);

        $usuario = Auth::user();

        if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
            return response()->json(['erro' => 'Senha incorreta'], 401);
        }

        $token = bin2hex(random_bytes(32));
        $usuario->token_apagar = $token;
        $usuario->save();

        $this->enviarEmailConfirmacaoApagarConta($usuario, $token);

        return response()->json(['status' => 'ok']);
    }

    private function enviarEmailConfirmacaoApagarConta($usuario, $token)
    {
        $link = route('conta.apagar.confirmar', ['token' => $token]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($usuario->email);

            $mail->isHTML(true);
            $mail->Subject = 'InteliSaúde - Exclusão de conta';
            $mail->Body = "
            Olá, <b>{$usuario->nome}</b>.<br><br>
            <h2>Clique no link abaixo para confirmar a exclusão da sua conta:</h2><br><br>
            <h1><a href='{$link}'>{$link}</a></h1><br><br>
            Se você não solicitou essa exclusão, ignore este e-mail.<br><br>
            <b>Obrigado,<br>InteliSaúde.</b>
        ";

            $mail->send();
        } catch (Exception $e) {
            Log::error('Erro ao enviar e-mail de exclusão de conta: ' . $mail->ErrorInfo);
        }
    }

    public function confirmarApagarConta($token)
    {
        $usuario = Usuario::where('token_apagar', $token)->first();

        if (!$usuario) {
            return redirect('/login')->with('erro', 'Token inválido ou expirado.');
        }

        $usuario->delete();

        return redirect('/')->with('mensagem', 'Sua conta foi apagada com sucesso.');
    }

}



