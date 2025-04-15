<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile_pic;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {    
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Client,Photographer'], 
            'profile_pic' => ['nullable', 'image', 'max:2048'], 

        ]);
        
        //dd($request->file('profile_pic'));
        $user = User::create([
           'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        
        // Guardar imagen o usar por defecto
        $path = 'profile_pics/default.jpg';

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
        } 
        

        $profile = Profile_pic::create([
            'user_id' => $user->id,
            'profile_pic' => $path,
        ]);
      

        // Iniciar sesión automáticamente
    Auth::login($user);

    // Redirigir según el rol
    if ($user->role === 'Client') {
        return redirect()->route('clients.mainClient');
    } elseif ($user->role === 'Photographer') {
        return redirect()->route('photos.mainPhoto');
    }

    // Si no se cumple ninguna de las condiciones anteriores
    return redirect(RouteServiceProvider::HOME);
    }
}
