<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuLogin">
        <div class="loginBranco">
            <div class="conteudoBranco">
                {{--form enviado pro login.submit --}}
                <form action="{{ route('login.submit') }}" method="POST">
                    {{-- insere um token CSRF para proteção contra ataques de falsificação de requisições --}}
                    @csrf
                    <h1>Login</h1>
                    <p class="textoBranco">Para acessar sua conta é necessário preencher o campo<br>abaixo com os seus
                        dados
                        de acesso.</p>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                    {{-- link para recuperar senha --}}
                    <a href={{ url('/recuperacaoConta') }}>Esqueceu sua senha?</a>
                    <button type="submit">Acessar</button>
                </form>
            </div>
        </div>
        <div class="loginAzul">
            <div class="conteudoAzul">
                <h1>Novo por aqui?</h1>
                <p class="textoAzul">Para conectar-se conosco, por favor crie uma conta</p>
                 {{-- link para cadastro senha --}}
                <button onclick="window.location.href = '{{ url('/') }}';">Criar conta</button>
            </div>
        </div>
    </div>

</body>

</html>