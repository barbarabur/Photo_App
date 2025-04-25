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
                        Uploaded: {{ $photo->created_at->format('d/m/Y') }} 
                    </h6>
                    <h6 class="card-subtitle mb-2 text-muted">
                        👁️ Views: {{ $photo->views }}
                    </h6>

                </div>
                <!-- Obtener el usuario (autor de la foto) y mostrar el nombre -->
                @php
                    $user = $photo->user;  // Obtener el usuario (autor) relacionado con la foto
                @endphp
                <p class="card-text">
                    <small class="text-muted">
                        Author: {{  $user->name }}
                    </small>
                </p>

                @if (auth()->check() && auth()->user()->role === 'Photographer')
                    <div class="d-flex flex-column align-items-end">
                        <!-- boton editar-->
                        <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-outline-dark mb-2">Edit</a>
                        <!-- Botón para eliminar foto -->
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $photo->id }}">Delete</button>

                    </div>
                @endif
            </div>

            <p class="card-text">{{ $photo->description }}</p>
            <p class="card-text"><strong>Price:</strong> {{ $photo->price }} €</p>

            <img src="{{ asset($photo->url) }}" alt="{{ $photo->title }}" class="img-fluid mb-3">

            <div class="card-text">
              @if ($photo->tags->isnotEmpty())
                <p class="strong">Tags:</p>
                @foreach($photo->tags as $tag)
                  <span class="badge bg-secondary">{{$tag->tag}}</span>
                @endforeach
              @else 
              <p>No tags avaliable</p>
            @endif
            </div>

            <!-- comentarios -->
            <div class="card-body">
                <h5 class="card-title"><strong></strong></h5>

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
                            <button type="submit" class="btn {{ $photoInOrder ? 'btn-secondary' : 'btn-primary' }} mb-3" {{ $photoInOrder ? 'disabled' : '' }}>
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
                                    ❤️ Liked
                                @else
                                    🤍 Like
                                @endif
                            </button>
                        </form>
                    @endif
                </div>  
            @endif  
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="deleteModal{{ $photo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $photo->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $photo->id }}">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this photo? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <!-- Bootstrap 5 JavaScript (Modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
