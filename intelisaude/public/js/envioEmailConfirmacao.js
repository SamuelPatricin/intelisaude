import { mostrarPopupSucessoEmail } from './popupSucessoEmail.js';
import { mostrarPopupErroEmail } from './popupErroEmail.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            if (response.ok) {
                const json = await response.json();
                if (json.mensagem) {
                    mostrarPopupSucessoEmail();
                }
            } else {
                const json = await response.json();
                if (json.erro) {
                    mostrarPopupErroEmail();
                }
            }
        });
    }
});
