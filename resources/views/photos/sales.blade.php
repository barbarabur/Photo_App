@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3> SOLD PHOTOS</h3>
    <p><strong>Total earnings: {{ $total }}€</strong></p>
    
    <div class="card mt-4">
    @if ($completedPhotos->isEmpty())
        <p>No completed order photos found.</p>
    @else

        <div class="row">
            @foreach ($completedPhotos as $photo)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <!-- Contenedor cuadrado -->
                        <div class="square-img-container">
                            <img src="{{ asset($photo->url) }}" class="square-img card-img-top" alt="{{ $photo->title }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo->title }}</h5>
                            <p class="card-text">{{ $photo->description }}</p>
                            <p><strong>{{ $photo->price }}€</strong></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    @endif
</div>
@endsection
