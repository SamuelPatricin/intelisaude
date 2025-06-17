<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exame;
use thiagoalessio\TesseractOCR\TesseractOCR;
use GuzzleHttp\Client;

class ExameController extends Controller
{
    public function enviar(Request $request)
    {
       
        $request->validate([
            'arquivo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
        ]);

        try {
            $arquivo = $request->file('arquivo');
            $nomeOriginal = $arquivo->getClientOriginalName();
            $extensao = strtolower($arquivo->getClientOriginalExtension());
            $caminho = $arquivo->store('exames', 'public');
            $caminhoCompleto = storage_path('app/public/' . $caminho);

            // Cria registro no banco (sem texto ainda)
            $exame = Exame::create([
                'usuario_id' => Auth::id(),
                'nome_arquivo' => $nomeOriginal,
                'caminho_arquivo' => $caminho,
            ]);

            $imagemParaOCR = $caminhoCompleto;


            if ($extensao === 'pdf') {
                $pngPath = storage_path('app/public/exames/' . pathinfo($nomeOriginal, PATHINFO_FILENAME) . '-' . uniqid() . '.png');

                $comando = "magick -density 300 \"{$caminhoCompleto}[0]\" -quality 90 \"{$pngPath}\"";
                exec($comando . ' 2>&1', $output, $retorno);

                if ($retorno !== 0) {
                    return response()->json([
                        'erro' => 'Falha ao converter PDF para imagem',
                        'comando' => $comando,
                        'retorno' => $retorno,
                        'output' => $output
                    ], 500);
                }

                $imagemParaOCR = $pngPath;
            }

        
            $textoExtraido = (new TesseractOCR($imagemParaOCR))
                ->lang('por')
                ->tessdataDir('C:\\Program Files\\Tesseract-OCR\\tessdata\\') // Se precisar setar a pasta tessdata
                ->run();

            
            $exame->texto_extraido = $textoExtraido;
            $exame->save();

           
            $analiseIa = $this->analisarComOpenAI($textoExtraido);

            $exame->analise_ia = $analiseIa;
            $exame->save();

            return response()->json([
                'texto_extraido' => $textoExtraido,
                'analise_ia' => $analiseIa,
            ]);
        } catch (\Exception $e) {
          
            return response()->json([
                'erro' => 'Erro no servidor: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    private function analisarComOpenAI(string $texto)
    {
        $apiKey = env('OPENAI_API_KEY');
        $client = new Client();

        $prompt = "Você é um assistente médico que analisa exames laboratoriais (NAO SE PASSE POR NENHUMA PESSOA OU INSTITUICAO). Gere a análise no 
                    seguinte formato: primeiro uma tabela HTML com os parâmetros, resultados, valores de 
                    referência e situação, depois uma explicação profissional contendo o máximo de informações possíveis 
                    (com o nome e idade do paciente quando possivel), e depois retornar recomendações de bons habitos e alimentacao com base nos resultados do exame. 
                    em parágrafos com formatação HTML (negrito, listas se necessário). 
                    Aqui está o texto do exame:\n\n" . $texto;


        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => "Bearer {$apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Você é um assistente médico útil e profissional.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 1500,
                    'temperature' => 0.7,
                ],
            ]);

            $body = json_decode($response->getBody(), true);
            $conteudo = $body['choices'][0]['message']['content'] ?? 'Nenhuma resposta da IA.';

          
            $conteudoLimpo = preg_replace('/<\/?(html|head|body|doctype|!DOCTYPE)[^>]*>/i', '', $conteudo);

            return trim($conteudoLimpo);
        } catch (\Exception $e) {
           
            return 'Erro ao analisar com IA: ' . $e->getMessage();
        }
    }
}
