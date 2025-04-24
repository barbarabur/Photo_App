En rutas tenemos qeu tener definidas las vistas de los formularios
<?php
Route::get('/photo/create', [PhotoController::class, 'create'])->name('photo.create');
Route::post('/photo', [PhotoController::class, 'store'])->name('photo.store');
?>
GET muestra
POST recibe datos

En el controlador en la function store se procesan los datos recibidos del formulario.

Ejemplo:


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

        <div class="mb-3">
            <label for="image" class="form-label">Select File</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" step="0.01" value="{{ old('price') }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        
        </div>

        <!-- tags -->
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>

            <select name="tags[]" id="tags" class="form-select @error('tags') is-invalid @enderror" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->tag }}
                    </option>
                @endforeach
            </select>
            @error('tags')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
         </div>

        <button type="submit" class="btn btn-primary">Subir</button>
    </form>

</div>

-------------------------------------------------------------------------------------
USAR FORM REQUEST
php artisan make:request StorePhotoRequest


