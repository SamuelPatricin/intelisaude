document.addEventListener('DOMContentLoaded', function () {
    const popupErro = document.getElementById('popupErro');

 
    if (typeof window.ERRO_CADASTRO !== 'undefined' && window.ERRO_CADASTRO) {
        popupErro.textContent = window.ERRO_CADASTRO;
        popupErro.style.display = 'block';

        setTimeout(() => {
            popupErro.style.display = 'none';
        }, 5000);
    }
});
