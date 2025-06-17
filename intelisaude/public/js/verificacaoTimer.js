document.addEventListener('DOMContentLoaded', function () {
    let tempo = window.TEMPO_RESTANTE || 0;
    const botaoReenviar = document.getElementById('reenviar');
    const timerSpan = document.getElementById('timer');
    const textoReenvio = document.getElementById('textoReenvio');

    if (!botaoReenviar || !timerSpan || !textoReenvio) return;

    if (tempo > 0) {
        botaoReenviar.disabled = true;

        const intervalo = setInterval(() => {
            tempo--;
            timerSpan.textContent = tempo;

            if (tempo <= 0) {
                clearInterval(intervalo);
                botaoReenviar.disabled = false;
                textoReenvio.style.display = 'none';
            }
        }, 1000);
    } else {
        textoReenvio.style.display = 'none';
    }
});
