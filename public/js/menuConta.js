const conta = document.querySelector('.conta');
    
let contaVisivel = false; // Flag para controlar a visibilidade da música

function mostrarConta() {
  if (contaVisivel) {
    esconderConta(); // Se a música já estiver visível, chama a função para escondê-la
  } else {
    conta.classList.add('visivel'); // Torna a música visível
    setTimeout(() => {
      conta.classList.add('subindo'); // Inicia a animação de subida
    }, 50); // Atraso pequeno para garantir que a classe 'visivel' seja aplicada primeiro
  }

  contaVisivel = !contaVisivel; // Alterna o estado de visibilidade da música
}

function esconderConta() {
  conta.classList.remove('subindo'); // Reverte a animação de subida
  conta.classList.add('descendo'); // Inicia a animação de descida
  setTimeout(() => {
    conta.classList.remove('visivel'); // Esconde a música após a animação
    conta.classList.remove('descendo'); // Remove a classe de descida
  }, 200); // Tempo igual à duração da animação
}