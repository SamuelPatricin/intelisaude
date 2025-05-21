<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Conta</title>

    <link rel="stylesheet" href="{{ asset('css/recuperacaoConta.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuRecuperaConta">
        <div class="conteudoRecuperaConta">
            {{--form enviado pro recuperacaoConta.enviar --}}
            <form action="{{ route('recuperacaoConta.enviar') }}" method="POST">
                {{-- insere um token CSRF para proteção contra ataques de falsificação de requisições --}}
                @csrf
                <img src="{{ asset('img/logo.png') }}">
                <h1>Redefinição de Senha</h1>
                <p id="textoRecuperaConta">Informe abaixo o seu e-mail de login, e em seguida <br>acesse o e-mail para
                    prosseguir com o passo a passo de <br>recuperação de acesso</p>
                <input type="email" id="email" name="email" placeholder="E-mail">
                <button type="submit">Enviar link de recuperação</button>
            </form>
        </div>
    </div>



</body>

</html>