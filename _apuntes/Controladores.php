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


public function index(){} //listado de los elementos de ese modelo
/**
     * Muestra la lista de eventos.
     */
    public function index()
    {
        $events = Event::with('zone')->get();
        return view('events.index', compact('events'));
    }
    public function index()
    {
        return response()->json(Adventure::all(), 200);
    }


public function create(){} // muestra el formulario para dar de alta nuevos elementos del modelo
public function store(){} //almacena en la base de datos el elemento creado con el formulario de create
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|string',
        'description' => 'nullable|string',
    ]);

    $adventure = Adventure::create($request->all());

    return response()->json($adventure, 201);
}
public function show(){} //muestra los datos de un modelo específico, habitualmente por su identificador
 /**
     * Muestra un evento en detalle.
     */
    public function show($id)
    {
        $event = Event::with('zone')->findOrFail($id);
        return view('events.show', compact('event'));
    }



public function edit(){} //muestra el formulario para editar un elemento existente del modelo. No para apis, en apis se utiliza update
public function edit($id)
{
    $adventure = Adventure::find($id);

    if (!$adventure) {
        return response()->json(['error' => 'Aventura no encontrada'], 404);
    }

    return response()->json($adventure, 200);
}


public function update(){} //actualiza en la base de datos el elementyo editado con el formulario de edit
 /**
     * Actualiza una aventura existente.
     */
    public function update(Request $request, $id)
    {
        $adventure = Adventure::find($id);

        if (!$adventure) {
            return response()->json(['error' => 'Aventura no encontrada'], 404);
        }

        $adventure->update($request->all());

        return response()->json($adventure, 200);
    }



    public function destroy (){} //elimina un elemento por su identificador
 /**
     * Elimina una aventura.
     */
    public function destroy($id)
    {
        $adventure = Adventure::find($id);

        if (!$adventure) {
            return response()->json(['error' => 'Aventura no encontrada'], 404);
        }

        $adventure->delete();

        return response()->json(['message' => 'Aventura eliminada correctamente'], 200);
    }


/**definir la ruta del controlador en  routes/api.php */

use App\Http\Controllers\AdventureController;

Route::apiResource('adventures', AdventureController::class);
