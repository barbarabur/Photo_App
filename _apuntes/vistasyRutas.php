<?php
/* VISTAS

para crear las vistas: 
-> touch resources/views/welcome.blade.php

LAs vistas se almacenan en resources/views/

@section define un bloque de contenido.

@yield muestra ese contenido desde la plantilla base.

@include se usa para incluir una subvista, x ej un navbar, footer... @include('partials.navbar')
Esto es como un “copiar y pegar” dinámico de esa vista dentro de otra.




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

Route::get('/photos', [PhotoController::class, 'index']);
Esto significa: cuando el usuario vaya a /photos, ejecuta el método index() del PhotoController.




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



