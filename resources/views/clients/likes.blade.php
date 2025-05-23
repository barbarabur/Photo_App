@extends('layouts.app')


@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Your liked Photos: </h2>

    @if ($photos ->isempty())
        <div class = "alert alert-info">
        Your Favourite list is empty. Like a photo to add it!
        </div>
    @else
        <div class ="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($photos as $photo)
                <div class = "col">
                    <div class = "card h-100 shadow-sm">
                        <a href="{{ route('photos.show', $photo->id) }}">
                        <img src="{{ asset($photo->url) }}" alt="{{ $photo->title }}" class="card-img-top">
                        </a>
                    <div class="card-body">
                            <h5 class="card-title">{{ $photo->title }}</h5>
                            <p class="card-text text-muted">{{ $photo->price }} €</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection