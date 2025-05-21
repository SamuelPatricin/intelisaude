<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; //  importa a classe que encapsula os dados do request
use App\Models\Usuario; // importa usuario
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RecuperacaoSenhaController extends Controller
{
    // Envia link de recuperação para o email
    public function enviarLink(Request $request)
    {
        // valida se email foi preenchido corretamente
        $request->validate(['email' => 'required|email']);

        // faz busca pelo email no bd
        $usuario = Usuario::where('email', $request->email)->first();
        // se nao encontrar, retorna erro
        if (!$usuario) {
            return back()->withErrors(['email' => 'E-mail não cadastrado']);
        }

        // se encontrar, gera token 
        $token = bin2hex(random_bytes(30));
        // armazena token na coluna reset_token
        $usuario->reset_token = $token;
        // adiciona validade de uma hora ao token
        $usuario->token_expira_em = now()->addHour();
        // salva no bd
        $usuario->save();

        // cria link com token e email incluso no mesmo (urlencode transforma caracter especial em codigo)
        $link = url('/novaSenha?token=' . $token . '&email=' . urlencode($usuario->email));

        // envia email
        $this->enviarEmailRecuperacao($usuario, $link);

        // retorna mensagem de sucesso
        return back()->with('mensagem', 'Link de recuperação enviado para seu e-mail.');
    }


    // Exibe a view para nova senha, valida token e email
    public function mostrarFormularioNovaSenha(Request $request)
    {
        // puxa o token do link
        $token = $request->query('token');
        // puxa o email do link
        $email = $request->query('email');

        // se nao encontrar o token ou o email, redireciona pra pagina anterior, e com mensagem de erro
        if (!$token || !$email) {
            return redirect('/recuperacaoConta')->withErrors(['erro' => 'Link inválido ou expirado.']);
        }

        // se tudo tiver ok, faz uma busca pelo email e pelo token no bd
        $usuario = Usuario::where('email', $email)
        // checa se token ta igual ao do link
            ->where('reset_token', $token)
            // checa se token nao expirou
            ->where('token_expira_em', '>', now())
            ->first();

            // se nao encontrar, redireciona pra pagina anterior, e com mensagem de erro
        if (!$usuario) {
            return redirect('/recuperacaoConta')->withErrors(['erro' => 'Link inválido ou expirado.']);
        }

        // se tudo tiver ok, exibe a view
        return view('novaSenha', ['email' => $email, 'token' => $token]);
    }

    // Atualiza a senha no banco, valida token e email
    public function atualizarSenha(Request $request)
    {
        // valida se a senha foi corrigida corretamente e os dados
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'senha' => 'required|min:6', 

        ]);

        // faz busca pelo email e pelo token (link) no bd
        $usuario = Usuario::where('email', $request->email)
        // verifica se token ta igual ao do link
            ->where('reset_token', $request->token)
            // verifica se token nao expirou
            ->where('token_expira_em', '>', now())
            ->first();

            // se nao encontrar, redireciona pra pagina anterior, e com mensagem de erro
        if (!$usuario) {
            return redirect('/recuperacaoConta')->withErrors(['erro' => 'Link inválido ou expirado.']);
        }

        // se tudo tiver ok, atualiza a senha
        $usuario->senha = bcrypt($request->senha);
        // troca token pra null
        $usuario->reset_token = null;
         // troca token pra null
        $usuario->token_expira_em = null;
        // salva senha no bd
        $usuario->save();

        // redireciona pra pagina de login com mensagem de sucesso
        return redirect('/login')->with('mensagem', 'Senha alterada com sucesso. Faça login.');
    }

    // Envia email com o link de recuperação
    private function enviarEmailRecuperacao($usuario, $link)
    {
        // cria instancia do email
        $mail = new PHPMailer(true);
        try {
            //configura o envio com smtp
            $mail->isSMTP();
            // define servidor smtp
            $mail->Host = 'smtp.gmail.com';
            // ativa autenticacao smtp (login e senha)
            $mail->SMTPAuth = true;
            // usuario e senha pra do usuario pra enviar email (pegos do .env)
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            // criptografia tls e porta 587
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // formatacao de caracteres do email
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            // define o remetente (email e nome)
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($usuario->email);

            // informa que o conteudo do email vai ser em html
            $mail->isHTML(true);
            // assunto do email
            $mail->Subject = 'InteliSaúde - Recuperação de Senha';
            // corpo do email
            $mail->Body = "
                <p>Olá, <b>{$usuario->nome}</b></p>
                <h2>Clique no link abaixo para redefinir sua senha:</h2>
                <h1><a href='$link'>$link</a></h1>
                <p>Este link é válido por 1 hora.</p>
                <p>Se você não solicitou essa alteração, ignore este e-mail.</p>
                <p><b>Obrigado,<br>InteliSaúde.</b></p>
            ";

            // envia o email
            $mail->send();
        } catch (Exception $e) {
            // Você pode registrar o erro aqui se quiser, ex:
            // \Log::error('Erro ao enviar email de recuperação: ' . $e->getMessage());
        }
    }
}
