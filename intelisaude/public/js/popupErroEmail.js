export function mostrarPopupErroEmail() {
    const popup = document.getElementById('popupErroEmail');
    popup.classList.add('show');

    setTimeout(() => {
        popup.classList.remove('show');
    }, 4000); 
}
