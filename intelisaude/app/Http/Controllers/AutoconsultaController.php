<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class AutoconsultaController extends Controller
{
    public function consultar(Request $request)
    {
        $request->validate([
            'sintomas' => 'required|string|min:5',
        ]);

        $sintomas = $request->input('sintomas');
        $user = Auth::user();

        $prompt = "Você é um assistente médico confiável. Um paciente relatou os seguintes sintomas: \"$sintomas\". 
        Com base nesses sintomas responda o paciente, se achar que seja uma doenca, responda seguindo os seguintes passos:
        1. Diga quais doenças ou condições podem estar relacionadas.
        2. Explique da forma mais detalhada possivel o por que esses sintomas podem estar ligados a essas doenças.
        3. Indique qual ou quais especialidades médicas ele deve procurar.
        4. Diga bons habitos e alimentos para comer que ajudam contra a doença ou sintoma.
        Responda em linguagem clara e profissional, com parágrafos formatados em HTML e informe os artigos cientificos consultados.";


        try {
            $client = new Client();
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Você é um assistente médico experiente.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 1500,
                    'temperature' => 0.7,
                ],
            ]);

            $body = json_decode($response->getBody(), true);
            $conteudo = $body['choices'][0]['message']['content'] ?? 'Nenhuma resposta da IA.';

            return response()->json([
                'resposta' => $conteudo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'erro' => 'Erro ao consultar IA: ' . $e->getMessage(),
            ], 500);
        }
    }
}
