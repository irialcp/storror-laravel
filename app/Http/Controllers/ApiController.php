<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getUnsplashImages(Request $request)
    {
        try {
            $query = $request->input('query', 'parkour'); // Accetta 'query' dal frontend
            $perPage = $request->input('per_page', 7);

            $accessKey = env('UNSPLASH_ACCESS_KEY');

            if (!$accessKey) {
                Log::error('UNSPLASH_ACCESS_KEY non configurata nel file .env');
                return response()->json(['error' => 'Chiave API Unsplash non configurata sul server.'], 500);
            }

            $response = Http::withHeaders([
                'Authorization' => 'Client-ID ' . $accessKey,
            ])->get('https://api.unsplash.com/search/photos', [
                'query' => $query,
                'per_page' => $perPage,
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                Log::error('Errore chiamata Unsplash API: ' . $response->body());
                return response()->json(['error' => 'Errore nel recupero immagini da Unsplash.', 'details' => $response->json()], $response->status());
            }

        } catch (\Exception $e) {
            Log::error('Eccezione durante la chiamata Unsplash API: ' . $e->getMessage());
            return response()->json(['error' => 'Si è verificato un errore interno del server.'], 500);
        }
    }

    public function sendChatGPTMessage(Request $request)
    {
        // Validazione del messaggio in ingresso
        $request->validate([
            'message' => 'required|string|max:1000', // Limite di 1000 caratteri per il messaggio
        ]);

        try {
            $apiKey = env('CHATGPT_API_KEY'); // Ottiene la chiave API dal file .env

            // Verifica se la chiave API è configurata
            if (!$apiKey) {
                Log::error('CHATGPT_API_KEY non configurata nel file .env');
                return response()->json(['error' => 'Chiave API ChatGPT non configurata sul server.'], 500);
            }

            $message = $request->input('message'); // Prende il messaggio dal corpo della richiesta JSON

            // Effettua la chiamata all'API di OpenAI (ChatGPT)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey, // La chiave è nel backend, al sicuro
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // Puoi scegliere il modello che preferisci
                'messages' => [['role' => 'user', 'content' => $message]],
                'max_tokens' => 150, // Limita la lunghezza della risposta del bot
            ]);

            // Controlla se la chiamata è andata a buon fine
            if ($response->successful()) {
                // Estrae la risposta dal JSON (percorsi multipli per maggiore robustezza)
                $botReply = $response->json('choices.0.message.content');

                // Restituisce la risposta al frontend
                return response()->json(['reply' => $botReply]);
            } else {
                // Logga l'errore completo e restituisci un messaggio più dettagliato
                Log::error('Errore chiamata ChatGPT API: ' . $response->body());
                return response()->json(['error' => 'Errore nella comunicazione con ChatGPT.', 'details' => $response->json()], $response->status());
            }

        } catch (\Exception $e) {
            // Cattura qualsiasi altra eccezione (es. problemi di rete, errori PHP)
            Log::error('Eccezione durante la chiamata ChatGPT API: ' . $e->getMessage());
            return response()->json(['error' => 'Si è verificato un errore interno del server.'], 500);
        }
    }
}