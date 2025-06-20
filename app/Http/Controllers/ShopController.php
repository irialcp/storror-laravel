<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Per il Query Builder
use Illuminate\Support\Facades\Log; // *** Importa il facade Log ***

class ShopController extends Controller
{
    /**
     * Mostra la pagina dello shop.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Puoi passare qui dati iniziali se necessario, ad esempio categorie
        return view('shop');
    }

    /**
     * Restituisce i prodotti in formato JSON.
     * Corrisponde alla logica di get_products.php.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts()
    {
        try {
            // Recupera tutti i prodotti dal database.
            // Assicurati che il nome della tabella sia 'products'
            $products = DB::table('products')->get(); // Restituisce una Collection di oggetti

            // Modifica i percorsi delle immagini per farli corrispondere alla nuova struttura
            $modifiedProducts = $products->map(function ($product) {
                // --- Logica per 'image' ---
                if (isset($product->image)) {
                    $originalImagePath = $product->image;
                    if (str_starts_with($originalImagePath, 'public/')) {
                        // Vecchio formato: 'public/nome_immagine.png'
                        $newImagePath = str_replace('public/', 'images/', $originalImagePath);
                    } elseif (str_starts_with($originalImagePath, 'images/')) {
                        // Nuovo formato: 'images/nome_immagine.png' (già corretto)
                        $newImagePath = $originalImagePath;
                    } else {
                        // Caso inaspettato, logga un avviso e usa un fallback o il percorso originale
                        Log::warning("Percorso immagine prodotto inaspettato: " . $originalImagePath);
                        $newImagePath = 'images/default.png'; // Potresti usare un'immagine di fallback
                    }
                    $product->image = asset($newImagePath);
                }

                // --- Logica per 'image_hover' (se presente) ---
                if (isset($product->image_hover)) {
                    $originalImageHoverPath = $product->image_hover;
                    if (str_starts_with($originalImageHoverPath, 'public/')) {
                        // Vecchio formato: 'public/nome_immagine_hover.png'
                        $newImageHoverPath = str_replace('public/', 'images/', $originalImageHoverPath);
                    } elseif (str_starts_with($originalImageHoverPath, 'images/')) {
                        // Nuovo formato: 'images/nome_immagine_hover.png' (già corretto)
                        $newImageHoverPath = $originalImageHoverPath;
                    } else {
                        // Caso inaspettato, logga un avviso e usa un fallback o il percorso originale
                        Log::warning("Percorso immagine hover prodotto inaspettato: " . $originalImageHoverPath);
                        $newImageHoverPath = 'images/default_hover.png'; // Potresti usare un'immagine di fallback
                    }
                    $product->image_hover = asset($newImageHoverPath);
                }
                return $product;
            });


            return response()->json($modifiedProducts);

        } catch (\Exception $e) {
            Log::error('Errore durante il recupero dei prodotti: ' . $e->getMessage()); // Usa Log::error
            return response()->json(['error' => 'Impossibile recuperare i dati dei prodotti.'], 500);
        }
    }

    /**
     * Mostra la pagina di dettaglio di un singolo prodotto.
     * (Esempio, se avevi product.php?id=X)
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showProduct($id)
    {
        // Recupera il prodotto specifico dal database
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            // Gestisci il caso in cui il prodotto non venga trovato
            abort(404); // O reindirizza a una pagina di errore
        }

        // --- Logica per 'image' ---
        if (isset($product->image)) {
            $originalImagePath = $product->image;
            if (str_starts_with($originalImagePath, 'public/')) {
                $newImagePath = str_replace('public/', 'images/', $originalImagePath);
            } elseif (str_starts_with($originalImagePath, 'images/')) {
                $newImagePath = $originalImagePath;
            } else {
                Log::warning("Percorso immagine prodotto inaspettato (showProduct): " . $originalImagePath);
                $newImagePath = 'images/default.png';
            }
            $product->image = asset($newImagePath);
        }

        // --- Logica per 'image_hover' (se presente) ---
        if (isset($product->image_hover)) {
            $originalImageHoverPath = $product->image_hover;
            if (str_starts_with($originalImageHoverPath, 'public/')) {
                $newImageHoverPath = str_replace('public/', 'images/', $originalImageHoverPath);
            } elseif (str_starts_with($originalImageHoverPath, 'images/')) {
                $newImageHoverPath = $originalImageHoverPath;
            } else {
                Log::warning("Percorso immagine hover prodotto inaspettato (showProduct): " . $originalImageHoverPath);
                $newImageHoverPath = 'images/default_hover.png';
            }
            $product->image_hover = asset($newImageHoverPath);
        }

        return view('product.show', ['product' => $product]);
    }
}