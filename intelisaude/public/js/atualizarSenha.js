document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formTrocaSenha');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const senha = document.getElementById('senha').value;
        const senhaNova = document.getElementById('senhaNova').value;
        const token = document.querySelector('input[name="_token"]').value;

        try {
            const response = await fetch('/enviar-link-troca-senha', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    senha: senha,
                    senha_nova: senhaNova
                })
            });

            if (response.ok) {
                const data = await response.json();
                alert('E-mail enviado com sucesso! Verifique sua caixa de entrada.');
                form.reset(); 
            } else {
                const erro = await response.json();
                alert(erro.erro || 'Erro ao enviar e-mail. Verifique sua senha.');
            }
        } catch (err) {
            console.error('Erro ao enviar requisição:', err);
            alert('Ocorreu um erro ao enviar o e-mail. Tente novamente mais tarde.');
        }
    });
});
