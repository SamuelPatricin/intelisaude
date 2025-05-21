<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InteliSaúde</title>

    <link rel="stylesheet" href="{{ asset('css/homePage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menuConta.css') }}">
    <link rel="stylesheet" href="{{ asset('css/autoconsulta.css') }}">


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="barraSuperior">
        <div class="barraBotoes">
            <button class="botaoSuperior ativo" id="botaoLeitura">Leitura de exame</button>
            <button class="botaoSuperior" id="botaoAutoConsulta">Autoconsulta</button>
            <div class="manterConta">
                <button id="botaoConta" onclick="mostrarConta()"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg></button>
            </div>
        </div>
    </div>
    <div class="menuHomePage">
        <div class="conteudoHomePage" id="conteudoLeitura">
            <img src="{{ asset('img/logo.png') }}">
            <div class="uploadArquivos">
                <label id="uploadDoc" for="fileInput">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                        <path
                            d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707z" />
                        <path
                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                    </svg> Arraste e solte seu arquivo aqui
                </label>
                <input type="file" multiple id="fileInput">
            </div>
            <p id="ou">ou</p>
            <label for="fileInput" id="botaoUpload">Adicionar documento</label>
            <p id="textoHomePage">Apenas <br><br><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                </svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-file-earmark-image" viewBox="0 0 16 16">
                    <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                    <path
                        d="M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1z" />
                </svg></p>
        </div>
    </div>

    <!-- Conteudo do menu lateral de conta-->
    <div class="conta">
        <h1>Dados da conta</h1>
        <div class="inputNome">
            <h3>Nome: <input type="text" id="inputNome" name="nome" value="{{ $usuario->nome }}" readonly> 
            <button type="button" id="editarNome"><svg id="iconeEditar" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                    <path fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                </svg></button></h3>
                <input type="hidden" id="token_csrf" value="{{ csrf_token() }}">
        </div>
        <h3>E-mail: <input type="email" name="email" value="{{ $usuario->email }}" readonly></h3>
        
        <p id="mensagemSucesso" style="display: none; position:absolute; top:280px">Nome alterado com sucesso.</p>

        <div class="botoesConta">
            <button onclick="window.location.href = '{{ url('/atualizarEmail') }}';" id="mudarEmail">Alterar e-mail</button> 
            <button onclick="window.location.href = '{{ url('/atualizarSenha') }}';" id="mudarSenha">Alterar senha</button>
            <button onclick="window.location.href = '{{ url('/apagarUsuario') }}';" id="apagarConta">Apagar conta</button>
        </div>
    </div>

    <script src="{{ asset('js/botaoSuperior.js') }}"></script>
    <script src="{{ asset('js/autoconsulta.js') }}"></script>
    <script src="{{ asset('js/menuConta.js') }}"></script>
        <script src="{{ asset('js/nome.js') }}"></script>
</body>

</html>