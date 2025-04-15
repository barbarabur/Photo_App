@extends('layouts.app')

@section('content')
    <div class="container">
       
        <div class="mt-4 d-flex justify-content-center"> <!-- Centra los botones -->
        @if (auth()->check())  <!-- Verificamos si el usuario está autenticado -->
                @php
                    $user = auth()->user();  // Obtenemos al usuario autenticado
                @endphp

                

            @else
                <!-- Mostrar botones de Log In y Register si no hay usuario autenticado -->
                <a href="{{ route('login') }}" class="btn btn-light me-2">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-light">Register</a>
            @endif

        </div>
    </div>
@endsection


