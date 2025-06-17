document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); 

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

        
        } catch (error) {
         
            console.error(error); 
        }
    });
});
