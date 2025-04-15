<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
       // Validar las credenciales
       $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerar la sesión para proteger contra secuestros
            $request->session()->regenerate();

            // Redirigir basado en el rol del usuario
            $user = Auth::user();
            
            if ($user->role == 'Client') {
                return redirect()->route('clients.mainClient'); // Redirige a la ruta de Client
            } elseif ($user->role == 'Photographer') {
                return redirect()->route('photos.mainPhoto'); // Redirige a la ruta de Photographer
            }

            // Redirige al lugar por defecto si el rol no es ninguno de los anteriores
            return redirect(RouteServiceProvider::HOME);
        }

        // Si las credenciales no son correctas, lanzar un error
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no son correctas.'],
        ]);
    
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
