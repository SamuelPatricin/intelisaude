<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apagar Usuário</title>

    <link rel="stylesheet" href="{{ asset('css/apagarUsuario.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuApagarUsuario">
        <div class="conteudoApagarUsuario">
            <form id="formApagarConta" method="POST">
                @csrf
                <img src="{{ asset('img/logo.png') }}">
                <h1>Apagar Usuário</h1>
                <p id="textoApagarUsuario">Informe abaixo a sua senha para confirmação. Em
                    <br>confirmação. Em seguida acesse o e-mail atual para
                    <br>seguida acesse o e-mail atual para prosseguir com o passo a
                    <br>passo para apagar o usuário.
                </p>
                <input type="password" id="senha" name="senha" placeholder="Senha">
                <button type="submit">Enviar e-mail</button>
            </form>
        </div>
    </div>


    <script src="{{ asset('js/apagarConta.js') }}"></script>
</body>

</html>