const botoes = document.querySelectorAll('.botaoSuperior');

  botoes.forEach(botao => {
    botao.addEventListener('click', () => {
      // Remove a classe "ativo" de todos
      botoes.forEach(b => b.classList.remove('ativo'));

      // Adiciona no que foi clicado
      botao.classList.add('ativo');
    });
  });