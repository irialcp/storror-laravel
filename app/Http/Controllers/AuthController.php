<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mostra il form di login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('shop');
        }
        return view('auth.login');
    }

    /**
     * Elabora la richiesta di login, usando email e password per l'autenticazione.
     */
    public function loginProcess(Request $request)
    {
        // 1. Validazione dell'input
        try {
            // Per il login standard di Laravel, ci concentriamo su email e password.
            // Il campo username verrà ricevuto, ma non usato direttamente in Auth::attempt.
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Email e password sono richieste e devono essere valide.',
                'errors' => $e->errors()
            ], 422);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // 2. Tentativo di autenticazione con Auth::attempt()
        if (Auth::attempt($credentials)) {
            // Autenticazione riuscita
            $request->session()->regenerate(); // Previene session fixation

            // Opzionale: puoi aggiornare il campo 'username' dell'utente se è diverso da quello inserito nel form
            // $user = Auth::user();
            // if ($user->username !== $request->input('username')) {
            //     $user->username = $request->input('username');
            //     $user->save();
            // }

            return response()->json(['success' => true, 'message' => 'Login effettuato con successo.', 'loggedIn' => true]);
        } else {
            // Autenticazione fallita
            return response()->json(['success' => false, 'message' => 'Email o password errati.', 'loggedIn' => false], 401);
        }
    }

    /**
     * Esegue il logout dell'utente.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('home');
    }

    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Elabora la richiesta di registrazione.
     */
    public function registerProcess(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                ],
                'confirm_password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore nella validazione dei dati.',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            if ($request->input('password') !== $request->input('confirm_password')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le password non corrispondono.',
                    'errors' => ['confirm_password' => ['Le password non corrispondono.']]
                ], 422);
            }

            // Creazione del nuovo utente - CAMBIATO DA 'username' A 'name'
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            Auth::login($user);

            $request->session()->regenerate();

            return response()->json(['success' => true, 'message' => 'Registrazione completata con successo! Ora sei loggato.', 'loggedIn' => true]);

        } catch (\Exception $e) {
            Log::error('Errore durante la registrazione: ' . $e->getMessage(), [
                'name' => $request->input('name'), // Logga il nome invece dello username
                'email' => $request->input('email'),
            ]);
            return response()->json(['success' => false, 'message' => 'Errore del server durante la registrazione. Riprova più tardi.'], 500);
        }
    }
}