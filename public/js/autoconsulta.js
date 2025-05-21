const conteudo = document.getElementById('conteudoLeitura');
  const conteudoOriginal = conteudo.innerHTML; // Salva o conteúdo original

  document.getElementById('botaoAutoConsulta').addEventListener('click', function () {
    conteudo.innerHTML = `
    <div class="menuAutoconsulta">
        <div class="conteudoAutoconsulta">
            <img src="img/logo.png">
            <h1>Autoconsulta inteligente com IA</h1>
            <h3>Com a ajuda da nossa inteligência artificial, você pode ter uma ideia do que pode estar <br>acontecendo com seu corpo. É rápido, fácil e gratuito.</h3>
            
            <div class="inputSintomas">
            <input placeholder = "Digite seus sintomas aqui" type="text"><button><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
</svg></button></input>
            </div>
            <p>Essa ferramenta não substitui um médico</p>

        </div>
    </div>
    `;
  });

  document.getElementById('botaoLeitura').addEventListener('click', function () {
    conteudo.innerHTML = conteudoOriginal;
  });