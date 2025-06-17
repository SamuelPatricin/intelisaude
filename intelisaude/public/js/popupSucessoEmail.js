document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const popup = document.getElementById("popupSucessoEmail");

    if (form) {
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.mensagem) {
                    popup.classList.add("show");

                    setTimeout(() => {
                        popup.classList.remove("show");
                    }, 5000);
                } else {
                    alert(data.erro || "Erro ao enviar e-mail.");
                }

            } catch (error) {
                console.error("Erro:", error);
                alert("Erro inesperado. Tente novamente.");
            }
        });
    }
});
