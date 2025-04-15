@extends('layouts.app')

@section('content')
    <div class="container">
    @php
        $name = auth()->user()->name; // Obtener el name del $user
    @endphp
    <div class="container">
    <div class="row align-items-center">
        <!-- Título -->
        <div class="col">
            <h1 class="mb-4">{{ $name }}'s Photographies</h1>
        </div>

        <!-- Botón para cargar fotos -->
        <div class="col">
            <a href="{{ route('photos.create') }}" class="btn btn-light mb-3 ">Upload photo</a>
        </div>
    </div>
</div>
        <hr>
        <!-- Mostrar fotos -->
        @if(auth()->check())
            @php
                $photos = auth()->user()->uploadPhoto;  // Obtener las fotos asociadas al usuario
            @endphp

            @if($photos && $photos->count() > 0)
                <div class="row">
                @foreach($photos as $photo)
                    <div class="col-md-4 mb-3">
                             <div class="card">
                             <a href="{{ route('photos.photoCard', $photo->id) }}">

                                 <!-- Mostrar la foto usando el campo URL -->
                                 <img src="{{ asset($photo->url) }}" class="card-img-top" alt="{{ $photo->title }}">
                                </a>
                                <div class="card-body">
                                   <h5 class="card-title">{{ $photo->title }}</h5>
                                    <p class="card-text">{{ $photo->description }}</p>
                                    <p class="card-text"><strong>Price::</strong> ${{ $photo->price }}</p>
                                    <p class="card-text"><small class="text-muted">Uploaded {{ $photo->created_at->format('d/m/Y') }}</small></p>
                                </div>
                            </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p>You haven't upload any photo yet. ¡Upolad one and get started!</p>
            @endif
        @else
            <p>Log in failed. Please, log in to see your pictures.</p>
        @endif
      
        
    </div>
@endsection
