document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Impede que a página recarregue

        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;

        const formData = new FormData();
        formData.append('email', email);
        formData.append('senha', senha);

        try {
            await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            // Nada é exibido, nenhuma mensagem. Tudo silencioso.
        } catch (error) {
            // Nem erros são exibidos. Também silencioso.
            console.error(error); // Só para debug no console, pode remover se quiser.
        }
    });
});
