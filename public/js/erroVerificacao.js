document.addEventListener('DOMContentLoaded', function () {
    const erro = window.ERRO_VERIFICACAO;
    const popupErro = document.getElementById('popupErro');

    if (erro && popupErro) {
        popupErro.textContent = erro;
        popupErro.style.display = 'block';

        setTimeout(() => {
            popupErro.style.display = 'none';
        }, 5000);
    }
});
