<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Http\Requests\PhotoRequest;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::with('user', 'tag');
        return response()->json($photos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhotoRequest $request)
    {
        $imagePath = $request->file('image')->store('photos', 'public');

        $photo = Photo::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'url' => 'storage/' . $imagePath,
            'user_id' => auth()->id(),
            'created_at' => now()
        ]);

        if ($request->has('tags')) {
            $photo->tags()->sync($request->input('tags'));
        }

        return response()->json([
            'message'=> 'Foto creada correctamente',
            'photo'=> $photo
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $photo = Photo::with('user', 'tags')->find($id);
        if (!$photo) {
            return response()->json(['message' => 'Foto no encontrada.'], 404);
        }
        return response()->json($photo, 200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PhotoRequest $request,  $id)
    {
        $photo = Photo::find($id);    

        if(!$photo) {
            return response()->json(['message' => 'Foto no encontrada.'], 404);
        }
        
        $photo->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        return response()->json([
            'message' => 'Foto actualizada correctamente.',
            'photo' => $photo
        ], 200);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $photo = Photo::find($id);
        $photo->delete();

        return response()->json(['message' => 'Foto eliminada'], 204);
    }
}
