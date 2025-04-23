@if(auth()->check())
    @if(auth()->user()->hasRole('Photographer'))
        <!-- Opción para editar -->
        <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-warning mb-3">Editar</a>
    @elseif(auth()->user()->hasRole('Client'))
        <!-- Opción para agregar a la orden -->
        <form action="{{ route('orders.add', $photo->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success mb-3">Añadir a la orden</button>
        </form>
    @endif
@else
    <p>No estás autenticado. Inicia sesión para realizar acciones.</p>
@endif

PARA BORRAR LA CACHÉ DE LAS VISTAS: 
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear

PARA COMPROBAR LA LISTA DE VISTAS: 
php artisan route:list



VISTAS
resources/
  views/
    layouts/
      app.blade.php    // Layout principal
    partials/
      header.blade.php // Componentes reutilizables
    home.blade.php     // Vista principal
    users/
      index.blade.php  // Vista para listar usuarios
      show.blade.php   // Vista para mostrar un usuario


para crear las vistas: 
-> touch resources/views/welcome.blade.php
-> touch resources/views/header.blade.php
-> touch resources/views/footer.blade.php

código vista:
// resources/views/photos/show.blade.php

@extends ('layouts.app')

@section ('content')

<div class="container mt-4">
    <div class="card">
    <div class="card-body">
        <!-- Encabezado: Título + botón Edit -->
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h5 class="card-title">{{ $photo->title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                  Uploaded: {{ $photo->created_at->format('d/m/Y') }} </h6>
          </div>
          <!-- Obtener el usuario (autor de la foto) y mostrar el nombre -->
          @php

                    $user = $photo->user;  // Obtener el usuario (autor) relacionado con la foto
                @endphp
                
                <p class="card-text">
                    <small class="text-muted">
                        Author: {{  $user->name}}
                    </small>
                </p>
              @if (auth()->check() && auth()->user()->role === 'Photographer')
                <div class="d-flex flex-column align-items-end">
                  <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-outline-dark mb-2">Edit</a>
                  <form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger mb-3">Delete</button>
                  </form>
                </div>
              @endif
          </div>
          @if (auth()->check() && auth()->user()->role === 'Client')
          <h6 class="card-subtitle mb-2 text-muted">
                  
            </h6>
            @endif
          <p class="card-text">{{ $photo->description }}</p>
          <p class="card-text"><strong>Price:</strong> {{ $photo->price }} €</p>

          <img src="{{ asset($photo->url) }}" alt="{{ $photo->title }}" class="img-fluid mb-3">

        
        <!-- comentarios -->
        <div class="card-body">
        <h5 class="card-title"><strong>Comments:</strong></h5>

        @include('comments.create') 
        </div> 

        <!--mostrar botones en funcion del usuario-->
        
        @if (auth()->check())
          @php
              $user = auth()->user(); // Obtener el usuario autenticado
          @endphp

        <div class="container">
         
          
          @if ($user->role === 'Client')

          <!-- Opción para agregar a la orden -->
          @php
              $order = \App\Models\Order::where('user_id', $user->id)
                          ->where('status', 'pending')
                          ->with('photos')
                          ->first();

              $photoInOrder = $order && $order->photos->contains('id', $photo->id);
          @endphp

                    
          <form action="{{ route('order.add', $photo->id) }}" method="POST">
              @csrf
              <button type="submit"
            class="btn {{ $photoInOrder ? 'btn-secondary' : 'btn-primary' }} mb-3"
            {{ $photoInOrder ? 'disabled' : '' }}>
        {{ $photoInOrder ? '✔ Already in order' : '➕ Add to order' }}
    </button>
          </form>

            <!--Opción para dar like -->
            @php
                $hasLiked = $photo->likes->contains('user_id', auth()->id());
            @endphp
              <form action="{{ route('clients.like', $photo->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn {{ $hasLiked ? 'btn-danger' : 'btn-outline-danger' }}">
                    @if ($hasLiked)
                      ❤️  Liked
                    @else
                      🤍  Like
                    @endif
                </button>
            </form>
            @endif
        </div>  
        @endif  
    </div>
  </div>
  
</div>
@endsection

