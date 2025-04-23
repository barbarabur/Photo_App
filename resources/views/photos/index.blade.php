@extends('layouts.app')

@section('content')
    <div class="container">
    {{-- Si el usuario es CLIENTE --}}
    @if(auth()->user()->role=== 'Client')
        @php
            $name = auth()->user()->name;
        @endphp
    <div class="col">
                <h1 class="mb-4">Welcome {{ $name }}</h1>
            </div>
        <h1 class="text-center mb-4">Search</h1>
        <div class="row">
            @foreach($photos as $photo)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <a href="{{ route('photos.show', $photo->id) }}">
                            <img src="{{ $photo->url }}" class="card-img-top" alt="{{ $photo->title }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo->title }}</h5>
                            <p class="card-text">{{ $photo->description }}</p>
                            <p class="card-text"><strong>Price:</strong> ${{ $photo->price }}</p>
                            <p class="card-text"><small class="text-muted">Uploaded: {{ $photo->created_at->format('d/m/Y') }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

       

    {{-- Si el usuario es FOTÓGRAFO --}}
    @elseif(auth()->user()->role === 'Photographer')
        @php
            $name = auth()->user()->name;
            $photos = auth()->user()->uploadPhoto;  // Obtener las fotos asociadas al usuario

        @endphp

        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-4">{{ $name }}'s Photographies</h1>
            </div>
            <div class="col">
                <a href="{{ route('photos.create') }}" class="btn btn-light mb-3">Upload photo</a>
            </div>
        </div>
        <hr>

        @if($photos && $photos->count() > 0)
            <div class="row">
                @foreach($photos as $photo)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <a href="{{ route('photos.show', $photo->id) }}">
                                <img src="{{ asset($photo->url) }}" class="card-img-top" alt="{{ $photo->title }}">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $photo->title }}</h5>
                                <p class="card-text">{{ $photo->description }}</p>
                                <p class="card-text"><strong>Price:</strong> ${{ $photo->price }}</p>
                                <p class="card-text"><small class="text-muted">Uploaded: {{ $photo->created_at->format('d/m/Y') }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>You haven't uploaded any photo yet. ¡Upload one and get started!</p>
        @endif

        @else
        <p>User role not recognized.</p>
        @endif
       
        
    </div>
@endsection
