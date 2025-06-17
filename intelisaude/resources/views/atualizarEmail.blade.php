<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar e-mail</title>

    <link rel="stylesheet" href="{{ asset('css/atualizarEmail.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <div class="menuAtualizarEmail">
        <div class="conteudoAtualizarEmail">
            <form method="POST" action="{{ route('email.troca.enviar') }}">
                @csrf
                <img src="{{ asset('img/logo.png') }}">
                <h1>Alterar e-mail</h1>
                <p id="textoAtualizarEmail">Informe abaixo o seu novo e-mail, e sua senha atual para
                    <br>confirmação. Em seguida acesse a caixa do e-mail novo, para
                    <br>prosseguir com o passo a passo de troca de e-mail de
                    <br>acesso.
                </p>
                <input type="email" id="email" name="email" placeholder="Novo e-mail" required>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
                <button type="submit">Enviar e-mail</button>
            </form>
        </div>
    </div>

    <div class="popup-sucesso-email" id="popupSucessoEmail">
        <div class="popup-conteudo">
            <p>Enviamos um link de verificação para o
                <br>e-mail novo. A alteração será
                <br>concluída após a confirmação.
            </p>
        </div>
    </div>

    <div id="popupErroEmail" class="popup-erro-email">
        Senha incorreta. Tente novamente.
    </div>


    <script src="{{ asset('js/atualizarEmail.js') }}"></script>
    <script src="{{ asset('js/popupSucessoEmail.js') }}"></script>
    <script src="{{ asset('js/envioEmailConfirmacao.js') }}" type="module"></script>
</body>

</html>