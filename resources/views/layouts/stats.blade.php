@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    @php
        $name = auth()->user()->name; // Obtener el name del $user
    @endphp  
    {{$name}}'s stats

<div class="card-body">
  <!-- Liked Photos -->
  <div class="card-body">
      <h5 class="card-header mt-4">Top Liked Photos</h5>
      <div class="row">
          @forelse($topLikedPhotos as $photo)
              <div class="col-md-4 mb-3">
                  <div class="card h-100">
                      <img src="{{ asset($photo->url) }}" class="card-img-top" alt="{{ $photo->title }}">
                      <div class="card-body">
                          <h5 class="card-title">{{ $photo->title }}</h5>
                          <p class="card-text">❤️ {{ $photo->likes_count }} likes</p>
                          <a href="{{ route('photos.show', $photo->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                      </div>
                  </div>
              </div>
          @empty
              <p class="text-muted">No hay fotos con likes todavía.</p>
          @endforelse
      </div>
  </div>      
  
  <!-- Sold Photos -->
  <div class="card-body">
      <h5 class="card-header mt-4">Sold Photos</h5>
      <p class="card-text">
          <a href="#" class="text-decoration-none"> Sold Photos</a>
      </p>
  </div>
      <!-- Photos in Charts -->
      <p class="card-text">
          <a href="#" class="text-decoration-none">📊 Photos in Charts</a>
      </p>
      
  </div>
</div>

</div>

@endsection