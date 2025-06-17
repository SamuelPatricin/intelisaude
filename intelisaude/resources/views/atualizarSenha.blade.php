<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar senha</title>

    <link rel="stylesheet" href="{{ asset('css/atualizarSenha.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuAtualizarSenha">
        <div class="conteudoAtualizarSenha">
            <form method="POST" id="formTrocaSenha">
                @csrf
                <img src="{{ asset('img/logo.png') }}">
                <h1>Alterar senha</h1>
                <p id="textoAtualizarSenha">Informe abaixo a sua senha atual para confirmação, e sua
                    <br>senha nova. Em seguida acesse o e-mail para prosseguir
                    <br>com o passo a passo de troca de senha de acesso.
                </p>
                <input type="password" id="senha" name="senha" placeholder="Senha atual">
                <input type="password" id="senhaNova" name="senha_nova" placeholder="Senha nova">
                <button type="submit">Enviar e-mail</button>
            </form>
        </div>
    </div>


    <script src="{{ asset('js/atualizarSenha.js') }}"></script>
</body>

</html>