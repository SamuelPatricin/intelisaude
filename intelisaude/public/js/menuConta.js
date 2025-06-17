const conta = document.querySelector('.conta');
    
let contaVisivel = false;

function mostrarConta() {
  if (contaVisivel) {
    esconderConta();
  } else {
    conta.classList.add('visivel'); 
    setTimeout(() => {
      conta.classList.add('subindo');
    }, 50); 
  }

  contaVisivel = !contaVisivel;
}

function esconderConta() {
  conta.classList.remove('subindo'); 
  conta.classList.add('descendo'); 
  setTimeout(() => {
    conta.classList.remove('visivel'); 
    conta.classList.remove('descendo');
  }, 200); 
}