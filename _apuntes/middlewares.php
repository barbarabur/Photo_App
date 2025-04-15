<?php
php artisan make:middleware NombredelMiddleware

app/http/middleware

modificar el archivo

//registrar el middleware en Kernel.php

array Middleware - Se ejecuta en cada petición o ruta

Middleware groups - Array donde se pueden añadir varios middleware. Se ejecutan todos los mw que contrine el grupo cada vez que se llama a una de las rutas del grupo.

middleware Aliases- Se ldde da un alias unico para llamrlo


Proteger solo para usuarios autenticados routes/web.php

Route::Middleware([‘auth’)]->group (function() {
	Route::post(‘/logout’, [AuthController::class, ‘logout’]”->name(‘logout’);
});

Vista Blade
<form action = ‘{{route(‘logout’)}}’ method = ‘Post’>
@csrf
<button type= ‘submit’>Cerrar Sesion</button>
</form>

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckActiveAdventureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || $user->activeAdventure) {
            return redirect()->route('adventure.show')->with('error', 'Aventura no encontrada.');
        }

        return $next($request);
    }
}