const botoes = document.querySelectorAll('.botaoSuperior');

  botoes.forEach(botao => {
    botao.addEventListener('click', () => {
   
      botoes.forEach(b => b.classList.remove('ativo'));

     
      botao.classList.add('ativo');
    });
  });