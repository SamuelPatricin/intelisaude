<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email',
            'senha' => 'required|min:6',
        ]);

        $usuarioExistente = Usuario::where('email', $request->email)->first();

        if ($usuarioExistente) {
            if ($usuarioExistente->verificado) {
                return back()->with('erro', 'Este e-mail já está em uso. Se você esqueceu sua senha, clique em <br>"Esqueceu sua senha?" na aba de login.');
            } else {
              
                $codigo = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
                $usuarioExistente->codigo_verificacao = $codigo;
                $usuarioExistente->senha = bcrypt($request->senha); 
                $usuarioExistente->save();

                $this->enviarEmail($usuarioExistente->nome, $usuarioExistente->email, $codigo);
                $request->session()->put('email', $usuarioExistente->email);

                return redirect('/codigoVerificacao')->with('mensagem', 'Novo código de verificação enviado para o seu e-mail.');
            }
        }

        
        $codigo = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
            'codigo_verificacao' => $codigo,
            'verificado' => false
        ]);

        $this->enviarEmail($usuario->nome, $usuario->email, $codigo);
        $request->session()->put('email', $usuario->email);
        $request->session()->put('ultimo_envio_codigo', time()); // ADICIONE ISSO

        return redirect('/codigoVerificacao');
    }

    private function enviarEmail($nome, $email, $codigo)
    {
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
            $mail->Encoding = 'base64';

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'InteliSaúde - Cadastro';
            $mail->Body = "Olá, <b>$nome</b>. <br><br>
                        Recebemos seu pedido de cadastro. Para concluir o processo de cadastro, insira o código de verificação informado abaixo. 
                        <br><br><br><h2>Seu código de verificação é:</h2> 
                            <br><h1 style='color: #19aaa7'><b>$codigo</b></h1>
                        <br><br>Este código é válido por 1 hora, além de ser pessoal, intransferível e não deve ser compartilhado com terceiros.
                        <br><br>Se você não solicitou este código, pode ignorar com segurança este e-mail.
                        <br><br>Outra pessoa pode ter digitado seu endereço de e-mail por engano.
                        <br><br><br><b>Obrigado,
                        <br>InteliSaúde.</b>";

            $mail->send();
        } catch (Exception $e) {
          
        }
    }

    public function verificarCodigo(Request $request)
    {
        $email = $request->session()->get('email');

        $usuario = Usuario::where('email', $email)->first();

        
        $codigoDigitado = strtoupper($request->codigo);

        if ($usuario && $codigoDigitado === $usuario->codigo_verificacao) {
            $usuario->verificado = true;
            $usuario->codigo_verificacao = null;
            $usuario->save();

            Auth::login($usuario);

            return redirect('/homePage');
        }

        return back()->with('erro', 'O código informado é inválido. Por favor, tente novamente.');
    }

    public function reenviarEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario) {
            return back()->with('erro', 'Usuário não encontrado.');
        }

        // Gera novo código
        $codigo = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $usuario->codigo_verificacao = $codigo;
        $usuario->save();

        $this->enviarEmail($usuario->nome, $usuario->email, $codigo);

        // Salva o timestamp atual em segundos na sessão para controlar o timer
        $request->session()->put('ultimo_envio_codigo', time());

        return back()->with('mensagem', 'Código reenviado com sucesso para o e-mail informado!');
    }

    public function mostrarCodigoVerificacao(Request $request)
    {
        $ultimoEnvio = $request->session()->get('ultimo_envio_codigo', 0);
        $agora = time();

        $tempoRestante = 30 - ($agora - $ultimoEnvio);
        if ($tempoRestante < 0) {
            $tempoRestante = 0;
        }

        return view('codigoVerificacao', ['tempoRestante' => $tempoRestante]);
    }
}

