<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Aggiunge un prodotto al carrello.
     */
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Utente non autenticato.'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);

        $userId = Auth::id();
        $productId = $request->input('product_id');

        try {
            $existingCartItem = DB::table('cart_items') // Corretto: cart -> cart_items
                ->where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existingCartItem) {
                DB::table('cart_items') // Corretto: cart -> cart_items
                    ->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->increment('quantity');
            } else {
                DB::table('cart_items')->insert([ // Corretto: cart -> cart_items
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Prodotto aggiunto al carrello con successo.'
            ]);

        } catch (\Exception $e) {
            Log::error('Errore durante l\'aggiunta al carrello: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'aggiunta al carrello.'
            ], 500);
        }
    }

    /**
     * Rimuove completamente un articolo dal carrello usando il cart_id.
     * Questo metodo corrisponde alla funzione `removeFromCart` nel JS.
     */
    public function removeCartItem(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Utente non autenticato.'
            ], 401);
        }

        $request->validate([
            'cart_id' => 'required|integer' // L'ID della riga nella tabella 'cart_items'
        ]);

        $userId = Auth::id();
        $cartId = $request->input('cart_id');

        try {
            $deleted = DB::table('cart_items') // Corretto: cart -> cart_items
                ->where('id', $cartId)
                ->where('user_id', $userId) // Assicura che l'utente stia rimuovendo solo i propri articoli
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Prodotto rimosso completamente dal carrello.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Elemento del carrello non trovato o non autorizzato.'
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Errore durante la rimozione completa dal carrello: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Errore del server durante la rimozione.'
            ], 500);
        }
    }


    /**
     * Ottiene gli articoli del carrello per l'utente autenticato.
     */
    public function getCartItems()
    {
        if (!Auth::check()) {
            // Se l'utente non è autenticato, restituisci un carrello vuoto o un messaggio
            // Questo è stato gestito nel JS per mostrare un messaggio specifico.
            return response()->json([]);
        }

        $userId = Auth::id();

        try {
            // Questo era già corretto
            $cartItems = DB::table('cart_items as ci')
                ->join('products as p', 'ci.product_id', '=', 'p.id')
                ->select(
                    'ci.id AS cart_id', // Essenziale per il JS
                    'p.id AS product_id',
                    'p.name AS NAME',
                    'p.price',
                    'p.image',
                    'ci.quantity'
                )
                ->where('ci.user_id', $userId)
                ->orderBy('p.name')
                ->get();

            // Adatta i percorsi delle immagini se necessario (come nel tuo codice originale)
            $modifiedCartItems = $cartItems->map(function ($item) {
                if (isset($item->image)) {
                    $originalImagePath = $item->image;
                    $newImagePath = str_replace('public/', 'images/', $originalImagePath);
                    $item->image = asset($newImagePath);
                }
                return $item;
            });

            return response()->json($modifiedCartItems);

        } catch (\Exception $e) {
            Log::error('Errore nel recupero del carrello: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Errore del server nel recupero del carrello. Riprova più tardi.'
            ], 500);
        }
    }

    /**
     * Aggiorna la quantità di un articolo nel carrello.
     * Questo metodo gestisce anche la rimozione se la quantità è <= 0.
     */
    public function updateCartItemQuantity(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Utente non autenticato.'
            ], 401);
        }

        $request->validate([
            'cart_id' => 'required|integer',
            'quantity' => 'required|integer|min:0' // Minimo 0, perché 0 significa eliminare
        ]);

        $userId = Auth::id();
        $cartId = $request->input('cart_id');
        $quantity = $request->input('quantity');

        try {
            if ($quantity <= 0) {
                // Se la quantità è 0 o meno, rimuovi l'articolo completamente
                $deleted = DB::table('cart_items') // Corretto: cart -> cart_items
                    ->where('id', $cartId)
                    ->where('user_id', $userId) // Assicura che l'utente stia rimuovendo solo i propri articoli
                    ->delete();

                if ($deleted) {
                     return response()->json([
                        'success' => true,
                        'message' => 'Articolo rimosso dal carrello.'
                    ]);
                } else {
                     return response()->json([
                        'success' => false,
                        'message' => 'Elemento del carrello non trovato per la rimozione.'
                    ], 404);
                }

            } else {
                // Altrimenti, aggiorna la quantità
                $updated = DB::table('cart_items') // Corretto: cart -> cart_items
                    ->where('id', $cartId)
                    ->where('user_id', $userId) // Assicura che l'utente stia aggiornando solo i propri articoli
                    ->update([
                        'quantity' => $quantity,
                        'updated_at' => now()
                    ]);

                if ($updated) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Quantità aggiornata con successo!'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Elemento del carrello non trovato o nessuna modifica.'
                    ], 404);
                }
            }

        } catch (\Exception $e) {
            Log::error('Errore durante l\'aggiornamento della quantità: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'aggiornamento della quantità.'
            ], 500);
        }
    }
}