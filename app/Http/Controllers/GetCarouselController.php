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

                if (str_starts_with($originalPath, 'public/')) {
                    $newPath = str_replace('public/', 'images/', $originalPath);
                } elseif (str_starts_with($originalPath, 'images/')) {
                    $newPath = $originalPath;
                } else {
                    Log::warning("Percorso immagine inaspettato nel database: " . $originalPath);
                    $newPath = 'images/default.png';
                }

                $item->image = asset($newPath);
                return $item;
            });

            return response()->json($modifiedCarouselItems);

        } catch (\Exception $e) {
            Log::error('Errore durante il recupero degli elementi del carosello: ' . $e->getMessage());
            return response()->json(['error' => 'Impossibile recuperare i dati del carosello.'], 500);
        }
    }
}