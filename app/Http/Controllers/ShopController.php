<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function index()
    {
        return view('shop');
    }

    public function getProducts()
    {
        try {
            $products = DB::table('products')->get();

            $modifiedProducts = $products->map(function ($product) {
                if (isset($product->image)) {
                    $originalImagePath = $product->image;
                    if (str_starts_with($originalImagePath, 'public/')) {
                        $newImagePath = str_replace('public/', 'images/', $originalImagePath);
                    } elseif (str_starts_with($originalImagePath, 'images/')) {
                        $newImagePath = $originalImagePath;
                    } else {
                        Log::warning("Percorso immagine prodotto inaspettato: " . $originalImagePath);
                        $newImagePath = 'images/default.png';
                    }
                    $product->image = asset($newImagePath);
                }

                if (isset($product->image_hover)) {
                    $originalImageHoverPath = $product->image_hover;
                    if (str_starts_with($originalImageHoverPath, 'public/')) {
                        $newImageHoverPath = str_replace('public/', 'images/', $originalImageHoverPath);
                    } elseif (str_starts_with($originalImageHoverPath, 'images/')) {
                        $newImageHoverPath = $originalImageHoverPath;
                    } else {
                        Log::warning("Percorso immagine hover prodotto inaspettato: " . $originalImageHoverPath);
                        $newImageHoverPath = 'images/default_hover.png';
                    }
                    $product->image_hover = asset($newImageHoverPath);
                }
                return $product;
            });


            return response()->json($modifiedProducts);

        } catch (\Exception $e) {
            Log::error('Errore durante il recupero dei prodotti: ' . $e->getMessage());
            return response()->json(['error' => 'Impossibile recuperare i dati dei prodotti.'], 500);
        }
    }
    
}

