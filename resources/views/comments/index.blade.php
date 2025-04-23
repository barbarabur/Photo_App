<div class="container">
    <h5 class="card-title"></h5>

    {{-- Comentarios existentes --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($comments as $comment)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">
                            @if ($comment->commentable_type == 'App\Models\Photo')
                                {{-- Mostrar el nombre del usuario que hizo el comentario en una foto --}}
                                {{ $comment->user->name }} 
                            @elseif ($comment->commentable_type == 'App\Models\User')
                                {{-- Mostrar el nombre del usuario que hizo el comentario en un perfil --}}
                                {{ $comment->user->name }} 
                            @endif
                        </h6>
                        <p class="card-text">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>