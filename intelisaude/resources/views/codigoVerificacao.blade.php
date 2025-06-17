<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar E-mail</title>

    <link rel="stylesheet" href="{{ asset('css/codigoVerificacao.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuVerificacao">
        <div class="conteudoVerificacao">
            <form action="{{ url('/verificar-codigo') }}" method="POST">
                @csrf
                <img src="{{ asset('img/logo.png') }}">
                <p id="textoVerificacao">Insira o código de verificação de 6 dígitos enviado para
                    <strong>{{ session('email') }}</strong>
                </p>
                <input type="text" id="codVerificacao" name="codigo" maxlength="6" required>
                <button id="confirmar" type="submit">Confirmar</button>
            </form>
            <form action="{{ route('reenviar.email') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <button id="reenviar" type="submit" @if($tempoRestante > 0) disabled @endif>Reenviar código</button>
                <p id="textoReenvio">Aguarde <span id="timer">{{ $tempoRestante }}</span> segundos antes de reenviar</p>
            </form>
        </div>
    </div>



    <div id="popupErro" style="
    display: none;
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color:rgb(255, 25, 0);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    font-weight: 600;
    font-family: 'Instrument Sans', Arial, sans-serif;
    z-index: 9999;
    max-width: 90%;
    text-align: center;
    animation: fadeIn 0.3s ease-out;
"></div>

    <script>
        window.TEMPO_RESTANTE = {{ $tempoRestante }};
    </script>
    <script src="{{ asset('js/verificacaoTimer.js') }}"></script>
    <script>
        window.ERRO_VERIFICACAO = @json(session('erro'));
    </script>

    <script src="{{ asset('js/erroVerificacao.js') }}"></script>
</body>

</html>