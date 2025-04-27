<?php
use App\Models\Modeloqueusemos;

//controladores una sola función _invoke(). Realizan una tarea y devuelven a la vista los datos procesados en esta.
php artisan make:controller UserController -i 

//controlador de API
php artisan make:controller AdventureController --api


//controladores CRUD create read update delete
php artisan make:controller UserController -r

//para los crud agregar a rutas web.php
Route::resource('photos', PhotoController::class);


 
public function index()//listado de los elementos de ese modelo
{
    $user = User::find(auth()->id());

    if ($user && $user->hasRole('Photographer')) {
            // Mostrar fotos del fotógrafo
            $photos = $user->photos()->with('user')->get(); 
            // Mostrar fotos del cliente 
            $photos = Photo::with('user')->get(); 
                }        
    return view('photos.index', compact('photos'));
}

public function index()
    {
        $tasks = $this->tasks;
        return view('tasks.index', compact('tasks'));
    }

public function create()// muestra el formulario para dar de alta nuevos elementos del modelo 
{
    $tags = Tag::all(); // Obtener todos los tags
    return view('photos.create', compact('tags')); // Pasar los tags a la vista. En esta vista se hace el formulario
} 

public function store(Request $request) //almacena en la base de datos el elemento creado con el formulario de create
    {
        $request->validate([
            'photo_ids' => 'required|array',
            'photo_ids.*' => 'exists:photos,id'
        ]);

        $total = Photo::whereIn('id', $request->photo_ids)->sum('price');

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'pending'
        ]);

        $order->photos()->attach($request->photo_ids);

        return redirect()->route('orders.index')->with('success', 'Order created.');
    }

public function show(){} //muestra los datos de un modelo específico, habitualmente por su identificador
public function show($id)
{
    $photo = Photo::findOrFail($id); // Buscar la foto por su ID
    $comments = $photo->comments()->with('user')->latest()->get();

    return view('photos.show', compact('photo', 'comments')); // Devuelve photo y comments para que las podamos usar como variables en la vista
}



public function edit($id)//muestra el formulario para editar un elemento existente del modelo. No para apis, en apis se utiliza update
{
    {
        $photo = Photo::findOrFail($id);       
        $tags = Tag::all(); // Obtener todos los tags
     
        return view('photos.edit', compact('photo', 'tags')); // Vista para editar la foto
    }
 
}


public function update(){} //actualiza en la base de datos el elemento editado con el formulario de edit. En APIS
public function update(Request $request, string $id)
{
    $photo = Photo::findOrFail($id);

    // Validación de los campos
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
    ]);

    // Actualizar solo los campos de texto (sin cambiar la imagen)
    $photo->update([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'price' => $request->input('price'),
    ]);

    return redirect()->route('photos.show', $photo->id)->with('success', 'Foto actualizada correctamente');
 }



    public function destroy (){//elimina un elemento por su identificador
    $photo->delete();
    return redirect()->route('photos.index')->with('success', 'Foto eliminada.');
}



/**definir la ruta del controlador en  routes/api.php */

use App\Http\Controllers\AdventureController;

