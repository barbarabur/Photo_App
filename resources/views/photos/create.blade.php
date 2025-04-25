@extends ('layouts.app')

@section('content')
<div class='container'>
    <h2>Upload Photo</h2>

    <!-- Muestra errores generales -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method = "POST" action ="{{route('photos.store') }}" enctype="multipart/form-data">
        @csrf 

    <!-- subida de archivo -->

        <div class="mb-3">
            <label for="image" class="form-label">Select File</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

     <!-- título -->

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror        
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01" value="{{ old('price') }}">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror        
        </div>

        <!-- tags -->
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>

            <select name="tags[]" id="tags" class="form-select" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->tag }}
                    </option>
                @endforeach
            </select>
            @error('tags')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            @error('tags.*')
                 <div class="text-danger">{{ $message }}</div>
            @enderror
         </div>

        <button type="submit" class="btn btn-primary">Subir</button>
    </form>

</div>
@endsection
