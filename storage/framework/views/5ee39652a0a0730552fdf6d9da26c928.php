<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>

    <link href="<?php echo e(asset('css/cadastro.css')); ?>" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuCadastro">
        <div class="cadastroBranco">
            <div class="conteudoBranco">
                <form id="formCadastro" action="<?php echo e(url('/cadastro')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <h1>Criar conta</h1>
                    <p class="textoBranco">Para ser cliente é necessário preencher o campo abaixo <br>com os respectivos
                        dados cadastrais.</p>
                    <input type="text" id="nome" name="nome" placeholder="Nome">
                    <input type="email" id="email" name="email" placeholder="E-mail">
                    <input type="password" id="senha" name="senha" placeholder="Senha">
                    <button type="submit">Cadastrar-se</button>
                </form>
            </div>
        </div>
        <div class="cadastroAzul">
            <div class="conteudoAzul">
                <h1>Bem-vindo de volta!</h1>
                <p class="textoAzul">Para continuar conectado conosco, por favor faça o <br>login</p>
                <button onclick="window.location.href = '<?php echo e(url('/login')); ?>';">Login</button>
            </div>
        </div>
    </div>



    <div id="popupErro" style="
    display: none;
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color:#ff0000;
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
        window.ERRO_CADASTRO = <?php echo json_encode(session('erro'), 15, 512) ?>;
    </script>

    <script src="<?php echo e(asset('js/erroCadastro.js')); ?>"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\inteliSaude\intelisaude\resources\views/cadastro.blade.php ENDPATH**/ ?>