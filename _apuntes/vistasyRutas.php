/* VISTAS

para crear las vistas: 
-> touch resources/views/welcome.blade.php

LAs vistas se almacenan en resources/views/

@section define un bloque de contenido.

@yield muestra ese contenido desde la plantilla base.

@include se usa para incluir una subvista, x ej un navbar, footer... @include('partials.navbar')
Esto es como un “copiar y pegar” dinámico de esa vista dentro de otra.


PARA BORRAR LA CACHÉ DE LAS VISTAS: 
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear

PARA COMPROBAR LA LISTA DE VISTAS: 
php artisan route:list



@extends('layout')
Sirve para heredar una plantilla base (comúnmente llamada layout).
aqui se pone el @yield ('content')

en home.blade, x ejemplo:
@extends('layouts.app')

@section('content')
    <h1>Bienvenido a la página de inicio</h1>
@endsection

Resultado: se rellena el @yield('content') de la plantilla base con lo que pongas en @section('content').

*/

Route::get('/photos', [PhotoController::class, 'index'])
// Esto significa: cuando el usuario vaya a /photos, ejecuta el método index() del PhotoController.

- GET----
Solicita información al servidor.
No cambia el estado de la aplicación (solo lee).

Usos típicos:
Mostrar una página.
Obtener datos de un recurso.
Mostrar un formulario vacío.

- POST -----
Envía datos al servidor.
Cambia el estado de la aplicación (crear, procesar, almacenar).

Usos típicos:
Guardar un nuevo recurso.
Procesar formularios.
Autenticación o registro.



//Mostras vistas desde ruta
Route::get('/', function () {
    return view('welcome', ['name' => 'Barbara']);
});
// Desde controlador:
public function index()
{
    return view('users.index', [
        'users' => User::all()
    ]);
}

//Estructuras de control

@if($condition)
    // Contenido
@elseif($anotherCondition)
    // Contenido alternativo
@else
    // Contenido por defecto
@endif

@foreach($users as $user)
    <li>{{ $user->name }}</li>
@endforeach



