@extends('layouts.app')

@section ('content')
<div class="container">
    <h1 class="text-center mb-4">Search</h1>
   
         <div class="row">
        @foreach($photos as $photo)
             <div class="col-md-4 mb-3">
                <div class="card">
                    <a href="{{ route('photos.photoCard', $photo->id) }}">

                                 <!-- Mostrar la foto usando el campo URL -->
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
</div>
@endsection
