<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Tag;
use App\Models\User;
use App\Models\Order;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PhotoRequest;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Navegación: Se accedió al listado de fotos.');

        $user = User::find(auth()->id());

    if ($user && $user->hasRole('Photographer')) {
            // Mostrar fotos del fotógrafo
            $photos = $user->photos()->with('user')->get(); 
    } else {
         // Mostrar fotos del cliente 
         $photos = Photo::with('user')->get(); 
    }        
        return view('photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('Navegación: Se accedió al formulario de creación de foto.');

        $tags = Tag::all(); // Obtener todos los tags
        return view('photos.create', compact('tags')); // Pasar los tags a la vista
     }

   
    public function store(PhotoRequest $request)
    {
       /* como hacemos la validación desde ell photoRequest quitamos esta parte  
       $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'array', // Asegurar que los tags sean un array
            'tags.*' => 'exists:tags,id',
        ]); */
 
 
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
        Log::info('Creación: Foto creadoa correctamente.', ['photo_id' => $photo->id]);

        return redirect()->route('photos.mainPhoto')->with('success', 'Foto subida correctamente.');
     }

    /**
     * Display the specified resource.
     */
    public function show($id)
   {
       $photo = Photo::findOrFail($id); // Buscar la foto por su ID
       $comments = $photo->comments()->with('user')->latest()->get();
       $tags = $photo->tags; // Obtener los tags relacionados

       return view('photos.show', compact('photo', 'comments', 'tags'));
   }


    //mostrar formulario de edicion
   public function edit($id)
   {
       $photo = Photo::findOrFail($id);       
       $tags = Tag::all(); // Obtener todos los tags
    
       return view('photos.edit', compact('photo', 'tags')); // Vista para editar la foto
   }

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
    
   public function destroy(Photo $photo)
   {
       $photo->delete();
       return redirect()->route('photos.index')->with('success', 'Foto eliminada.');
   }

   public function photosConLike ()
   {
       $user = Auth::user();
       //obtener likes tipo foto
       $likes = $user->likes->where('likeable_type', Photo::class);

       //obtener las fotos desde los likes
       $photos = $likes->map(function($like) {
           return $like->likeable;
       });

       return view('clients.likes', ['photos' => $photos]);

   }
    //dar like a una foto
   public function like(Photo $photo) {
    $user = Auth::user();

    $existingLike = $photo->likes()->where('user_id', $user->id)->first();
        if ($existingLike) {
            $existingLike ->delete();
        } else {
            $photo->likes()->create([
                'user_id' =>$user->id,
            ]);
        }

    return back();
    }

    //para aplicar el middleware de contar vistas solo en la vista show
    public function __construct()
    {
        $this->middleware('count.views')->only('show');
    }
    
    //para mostrar las fotos con más likes

    public function stats()
    {
        $user = Auth::user();
        $topLikedPhotos = Photo::withCount('likes')
            ->where('user_id', $user->id)
            ->orderBy('likes_count', 'desc')
            ->take(10)
            ->get();
        
        return view('layouts.stats', compact('topLikedPhotos'));
    }

    //para mostrar las fotos vendidas de un user

    public function completedOrderPhotos()
    {    //dd('Llegamos a completedOrderPhotos');

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Obtener todas las fotos del usuario autenticado
        $photos = $user->photos;

        $completedOrders = Order::where('status', 'completed')
            ->whereHas('photos', function ($query) use ($photos) {
                // Filtrar las órdenes que contienen fotos del usuario
                $query->whereIn('photos.id', $photos->pluck('id'));  // Filtrar por las fotos del usuario autenticado
            })
            ->with('photos')  // Cargar las fotos relacionadas
            ->get();
        // Obtener todas las fotos de esas órdenes
        $completedPhotos = $completedOrders->flatMap(function ($order) {
            return $order->photos;
            });
        
        $total = $completedPhotos->sum('price');

        // Pasar las fotos completadas a la vista
        return view('photos.sales', compact('completedPhotos', 'total'));

    }
}
