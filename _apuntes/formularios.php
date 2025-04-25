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
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
           
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control " name="title" id="title" value="{{ old('title') }}">
           
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control " name="description" id="description" rows="3">{{ old('description') }}</textarea>
                   
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01" value="{{ old('price') }}">
                   
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
         </div>

        <button type="submit" class="btn btn-primary">Subir</button>
    </form>

</div>

-------------------------------------------------------------------------------------
USAR FORM REQUEST--> Se usa para reunir las validaciones en una clase y asi que el codigo del controlador quede más limpio

php artisan make:request PhotoRequest

<?php
public function authorize() //devuelve booleano indicando si se qrequiere autorización para usar esta request
{
    return true; 
}

public function rules() //se indican las reglas de validación
{
    return [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        ];
}

public function messages() {
    return [
        'title.required' => 'The title is required.',
        'title.string' => 'The title must be a string.',
        'title.max' => 'The title must not be more than 255 characters.',        
        'description.required' => 'The description is required.',
        'price.required' => 'The price is required.',
    ];
}
?>

En el controlador se borra la funcion validate porque ya validamos aquí

En la vista se modifica para enlazar los mensajes de error que hemos generado:

    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
    @error('title')
        <div class="text-danger">{{ $message }}</div>
    @enderror


