<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PhotoController extends Controller
{
    public function create()
    {
        $tags = Tag::all(); // Obtener todos los tags
        return view('photos.create', compact('tags')); // Pasar los tags a la vista
    }
    
    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'array', // Asegurar que los tags sean un array
            'tags.*' => 'exists:tags,id',
        ]);

        //Guardar imagen en storage/public/photos
        $imagePath = $request->file('image') ->store('photos', 'public');

        //crear foto
        $photo = Photo::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'url' => 'storage/' . $imagePath,
            'user_id' => auth()->id(),
            'created_at' => now()
        ]);
        
        // Asociar los tags a la foto
        if ($request->has('tags')) {
            $photo->tags()->sync($request->input('tags'));
        }
        
        return redirect()->route('photos.mainPhoto')->with('success', 'Foto subida correctamente.');
    }  
    
    public function show($id)
    {
        $photo = Photo::findOrFail($id); // Buscar la foto por su ID
        $comments = $photo->comments()->with('user')->latest()->get();

        return view('photos.photoCard', compact('photo', 'comments'));
    }

    //mostrar formulario de edicion
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);        
        
        $tags = Tag::all(); // Obtener todos los tags
            
       
        return view('photos.edit', compact('photo', 'tags')); // Vista para editar la foto
    }

    public function update(Request $request, $id)
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
    
    public function index() {
        $photos = Photo::all(); 
    return view('photos.index', compact('photos'));
    }
    public function destroy(Photo $photo)
    {
        $photo->delete();

        return redirect()->route('photos.mainPhoto')->with('success', 'Comentario eliminado.');
    }

    public function mainPhoto() {
        return view('photos.mainPhoto');
    }

}