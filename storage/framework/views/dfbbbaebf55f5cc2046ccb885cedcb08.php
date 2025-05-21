<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>

    <link rel="stylesheet" href="<?php echo e(asset('css/novaSenha.css')); ?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap">
</head>

<body>

    <div class="menuNovaSenha">
        <div class="conteudoNovaSenha">
            
            <form action="<?php echo e(route('novaSenha.atualizar')); ?>" method="POST">
                
                <?php echo csrf_field(); ?>
                
                <input type="hidden" name="email" value="<?php echo e(request()->email); ?>">
                
                <input type="hidden" name="token" value="<?php echo e(request()->token); ?>">

                <img src="<?php echo e(asset('img/logo.png')); ?>">
                <h1>Redefinição de Senha</h1>
                <p id="textoNovaSenha">Digite uma nova senha no campo abaixo</p>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
                <button type="submit">Confirmar nova senha</button>
            </form>
        </div>
    </div>

</body>

</html><?php /**PATH C:\xampp\htdocs\inteliSaude\intelisaude\resources\views/novaSenha.blade.php ENDPATH**/ ?>