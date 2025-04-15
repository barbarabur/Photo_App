@extends ('layouts.app')

@section('content')
<div class='container'>
    <h2>Upload Photo</h2>
    <form method = "POST" action ="{{route('photos.store') }}" enctype="multipart/form-data">
        @csrf 
        <div class="mb-3">
            <label for="image" class="form-label">Select File</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="string" class="form-control" name="title" id="title" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01" required>
        </div>
        <!-- tags -->
        <div> 
            <label for="tags">Tags</label>

            <select name="tags[]" id="tags" class="form-select" multiple required>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>

                @endforeach
            </select>
         </div>

        <button type="submit" class="btn btn-primary">Subir</button>
    </form>

</div>
@endsection
