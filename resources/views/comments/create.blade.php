<div class=container>
    
    @include('comments.index') 

    {{-- Formulario para nuevo comentario --}}

    <form method = "POST" action ="{{route('comments.store') }}" enctype="multipart/form-data">
        @csrf 
        <input type="hidden" name="commentable_id" value="{{ $photo->id }}"> <!-- ID del recurso -->
        <input type="hidden" name="commentable_type" value="App\Models\Photo"> <!-- Clase del recurso -->

        <div class="mb-3">
            <label for="content" class="form-label">Comment: </label>
            <textarea class="form-control" name="content" id="content" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-light">Submit</button>

    </form>
</div>