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
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('shop');
        }
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        try {
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

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return response()->json(['success' => true, 'message' => 'Login effettuato con successo.', 'loggedIn' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Email o password errati.', 'loggedIn' => false], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('home');
    }

    public function showSigninForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.signin');
    }

    public function signinProcess(Request $request)
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
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);
            return response()->json(['success' => false, 'message' => 'Errore del server durante la registrazione. Riprova più tardi.'], 500);
        }
    }
}