document.addEventListener('DOMContentLoaded', () => {
    const botaoLeitura = document.getElementById('botaoLeitura');
    const botaoAutoConsulta = document.getElementById('botaoAutoConsulta');
    const conteudo = document.getElementById('conteudoLeitura');
    const fileInput = document.getElementById('fileInput');
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.content : '';

    if (!sessionStorage.getItem('conteudoLeituraAtual') && conteudo) {
        sessionStorage.setItem('conteudoLeituraAtual', conteudo.innerHTML);
    }

    // ---------------- FUNÇÃO: Monta Autoconsulta ----------------
    function montarAutoconsulta() {
        if (!conteudo) return;

        conteudo.innerHTML = `
      <div class="menuAutoconsulta">
        <div class="conteudoAutoconsulta">
          <img src="img/logo.png" alt="Logo" />
          <div id="blocoRespostaIA" class="resultadoIA">
            <h1 id="tituloAutoConsulta">Autoconsulta inteligente com IA</h1>
            <h3>Com a ajuda da nossa inteligência artificial, você pode ter uma ideia do que pode estar <br>acontecendo com seu corpo. É rápido, fácil e gratuito.
            <brAs informações inseridas neste chatbot, e as respostas geradas pela IA neste chatbot, são processadas em tempo real e NÃO SÃO ARMAZENADAS pelo sistema. Nenhum dado pessoal é retido, garantindo sua privacidade.</h3>
          </div>
          <div class="inputSintomas">
            <input id="inputSintomas" placeholder="Digite seus sintomas aqui" type="text" value="${sessionStorage.getItem('sintomasUsuario') || ''}" />
            <button id="botaoEnviarSintomas" title="Enviar">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
              </svg>
            </button>
          </div>
          <p id="avisoIA">Essa ferramenta não substitui um médico</p>
        </div>
      </div>
    `;

        const inputSintomas = document.getElementById('inputSintomas');
        inputSintomas.addEventListener('input', () => {
            sessionStorage.setItem('sintomasUsuario', inputSintomas.value);
        });

        document.getElementById('botaoEnviarSintomas').addEventListener('click', () => {
            const sintomas = inputSintomas.value.trim();
            if (!sintomas) return;

            fetch('/autoconsulta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ sintomas })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.resposta) {
                        document.getElementById('tituloAutoConsulta').innerText = 'Autoconsulta Inteligente';
                        document.querySelector('#tituloAutoConsulta + h3')?.remove();

                        const blocoResposta = document.getElementById('blocoRespostaIA');

                        // Mostra os sintomas digitados, alinhado à direita
                        const sintomasDiv = document.createElement('div');
                        sintomasDiv.classList.add('sintomasContainer'); // container flex
                        sintomasDiv.innerHTML = `<div class="sintomasUsuario">${sintomas}</div>`;
                        document.getElementById('blocoRespostaIA').appendChild(sintomasDiv);

                        // Mostra a resposta da IA
                        const respostaDiv = document.createElement('div');
                        respostaDiv.classList.add('respostaIA');
                        respostaDiv.innerHTML = data.resposta;
                        blocoResposta.appendChild(respostaDiv);

                        document.querySelector('.conteudoAutoconsulta').classList.add('comScroll');
                    } else {
                        conteudo.innerHTML += `<p>Não foi possível obter uma resposta da IA.</p>`;
                    }
                })
                .catch(err => {
                    console.error(err);
                    conteudo.innerHTML += `<p>Erro ao consultar a IA. Tente novamente mais tarde.</p>`;
                });
        });
    }

    // ---------------- FUNÇÃO: Monta Leitura ----------------
    function montarLeitura() {
        const conteudoSalvo = sessionStorage.getItem('conteudoLeituraAtual') || '';
        if (conteudo) conteudo.innerHTML = conteudoSalvo;
    }

    // ---------------- EVENTOS: Botões ----------------
    botaoAutoConsulta?.addEventListener('click', () => {
        montarAutoconsulta();
        botaoAutoConsulta.classList.add('ativo');
        botaoLeitura?.classList.remove('ativo');
    });

    botaoLeitura?.addEventListener('click', () => {
        montarLeitura();
        botaoLeitura.classList.add('ativo');
        botaoAutoConsulta?.classList.remove('ativo');
    });

    // ---------------- FUNÇÃO: Leitura de Exame ----------------
    fileInput?.addEventListener('change', async function () {
        const file = fileInput.files[0];
        if (!file) return;

        const uploadDiv = document.querySelector('.uploadArquivos');
        if (!uploadDiv) return;

        uploadDiv.innerHTML = `<p><b>Fazendo leitura de:</b> ${file.name}</p>`;

        const formData = new FormData();
        formData.append('arquivo', file);

        try {
            const response = await fetch('/enviar-exame', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            if (!response.ok) throw new Error('Erro ao enviar o arquivo');

            const result = await response.json();
            if (result.analise_ia && result.analise_ia.trim() !== '') {
                sessionStorage.setItem('resultadoIAExame', result.analise_ia);
            } else {
                sessionStorage.removeItem('resultadoIAExame');
            }

            const respostaFormatada = marked.parse(result.analise_ia || 'Sem análise');

            uploadDiv.innerHTML = `
  <div class="blocoResultadoIA">
    <h1 style="text-align: center; margin-bottom: 20px;">Resultado da Leitura:</h1>
    <div class="conteudoRespostaIA">${respostaFormatada}</div>
  </div>

`;

            document.getElementById('ou')?.remove();
            document.getElementById('botaoUpload')?.remove();
            document.getElementById('textoHomePage')?.remove();

            sessionStorage.setItem('conteudoLeituraAtual', uploadDiv.parentElement.innerHTML);

        } catch (error) {
            uploadDiv.innerHTML = `<p style="color:red;">Erro ao enviar o arquivo: ${error.message}</p>`;
            sessionStorage.removeItem('resultadoIAExame');
        }
    });
});
