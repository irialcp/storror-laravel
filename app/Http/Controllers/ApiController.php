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
            $perPage = $request->input('per_page', 9); // O 5 come nel tuo JS originale

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
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $apiKey = env('CHATGPT_API_KEY');

            if (!$apiKey) {
                Log::error('CHATGPT_API_KEY non configurata nel file .env');
                return response()->json(['error' => 'Chiave API ChatGPT non configurata sul server.'], 500);
            }

            $message = $request->input('message');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $message]],
                'max_tokens' => 150,
            ]);

            if ($response->successful()) {
                $botReply = $response->json('choices.0.message.content');
                return response()->json(['reply' => $botReply]);
            } else {
                Log::error('Errore chiamata ChatGPT API: ' . $response->body());
                return response()->json(['error' => 'Errore nella comunicazione con ChatGPT.', 'details' => $response->json()], $response->status());
            }

        } catch (\Exception $e) {
            Log::error('Eccezione durante la chiamata ChatGPT API: ' . $e->getMessage());
            return response()->json(['error' => 'Si è verificato un errore interno del server.'], 500);
        }
    }
}