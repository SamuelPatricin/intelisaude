document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formApagarConta');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('/conta/enviar-link-apagar-conta', { 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData
        })
        .then(() => {
        })
        .catch(() => {
        });
    });
});
