<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
class GetCarouselController extends Controller
{
    public function getCarouselItems()
    {
        try {
            $limit = 6; 
            $carouselItems = DB::table('products')
                                ->select('image')
                                ->orderBy('id', 'asc')
                                ->limit($limit) 
                                ->get();

            $modifiedCarouselItems = $carouselItems->map(function ($item) {
                $originalPath = $item->image;

                // Controlla se il percorso necessita della trasformazione 'public/' -> 'images/'
                if (str_starts_with($originalPath, 'public/')) {
                    // Vecchio formato: 'public/nome_immagine.png'
                    $newPath = str_replace('public/', 'images/', $originalPath);
                } elseif (str_starts_with($originalPath, 'images/')) {
                    // Nuovo formato: 'images/nome_immagine.png' (già corretto)
                    $newPath = $originalPath;
                } else {
                    // Gestisci altri casi o logga un avviso se ci sono path inaspettati
                    Log::warning("Percorso immagine inaspettato nel database: " . $originalPath);
                    $newPath = 'images/default.png'; // Fallback o gestisci l'errore
                }

                $item->image = asset($newPath); // Genera l'URL completo
                return $item;
            });

            return response()->json($modifiedCarouselItems);

        } catch (\Exception $e) {
            Log::error('Errore durante il recupero degli elementi del carosello: ' . $e->getMessage());
            return response()->json(['error' => 'Impossibile recuperare i dati del carosello.'], 500);
        }
    }
}