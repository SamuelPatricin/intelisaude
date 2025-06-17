⚙️ Requisitos para uso do sistema InteliSaúde

O sistema InteliSaúde foi desenvolvido com o framework Laravel (PHP), e para que ele funcione corretamente em sua máquina, é necessário que os seguintes componentes e configurações estejam presentes e corretamente instalados:

🧩 Dependências obrigatórias:

1. ImageMagick
   Utilizado para o pré-processamento das imagens dos exames enviados, otimizando a leitura via OCR.

2. Tesseract OCR
   Responsável por extrair texto das imagens dos exames.

   > É necessário utilizar a biblioteca PHP desenvolvida por Thiago Alessio, que permite a integração do Tesseract com o backend em PHP.
   
   > Exemplo de instalação via Composer: composer require thiagoalessio/tesseract_ocr

3. GhostScript
   Utilizado para conversão e manipulação de arquivos PDF, especialmente quando o exame é enviado nesse formato.

4. PHPMailer
   Biblioteca usada para envio de e-mails no sistema, incluindo verificação de conta, redefinição de senha e envio de links de confirmação.

5. Chave de API do ChatGPT (OpenAI)
   Necessária para uso dos recursos de IA no sistema.

   > O sistema utiliza o modelo GPT-3.5 Turbo para análise de sintomas e geração de respostas automáticas.

---

⚙️ Configuração do `.env`

Além da instalação das dependências, é necessário configurar o arquivo `.env` com:

* Credenciais do banco de dados (host, nome, usuário e senha)
* Chave da API da OpenAI

Exemplo de configuração:

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=intelisaude
DB_USERNAME=root
DB_PASSWORD=sua_senha

OPENAI_API_KEY=sua_chave_api

---

✅ Conclusão

Antes de executar o sistema, certifique-se de que:

* Todos os componentes acima estejam instalados e funcionando corretamente;
* O banco de dados esteja criado e configurado;
* O arquivo `.env` esteja preenchido com as informações corretas.

