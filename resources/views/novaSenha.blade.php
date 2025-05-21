<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>

    <link rel="stylesheet" href="{{ asset('css/novaSenha.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuNovaSenha">
        <div class="conteudoNovaSenha">
            {{--form enviado pro novaSenha.atualizar --}}
            <form action="{{ route('novaSenha.atualizar') }}" method="POST">
                {{-- insere um token CSRF para proteção contra ataques de falsificação de requisições --}}
                @csrf
                {{-- armazena email --}}
                <input type="hidden" name="email" value="{{ request()->email }}">
                {{-- armazena token --}}
                <input type="hidden" name="token" value="{{ request()->token }}">

                <img src="{{ asset('img/logo.png') }}">
                <h1>Redefinição de Senha</h1>
                <p id="textoNovaSenha">Digite uma nova senha no campo abaixo</p>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
                <button type="submit">Confirmar nova senha</button>
            </form>
        </div>
    </div>

</body>

</html>