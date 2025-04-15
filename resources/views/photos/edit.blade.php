@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Foto</h2>
    <form action="{{ route('photos.update', $photo->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Se usa para indicar que es una actualización -->
        <img src="{{ asset($photo->url) }}" alt="{{ $photo->title }}" class="img-fluid mb-3">

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $photo->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $photo->description) }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $photo->price) }}" required>
        </div>

        <div> 
            <label for="tags">Tags</label>

            <select name="tags[]" id="tags" class="form-select" multiple required>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>

                @endforeach
            </select>
         </div>


        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection