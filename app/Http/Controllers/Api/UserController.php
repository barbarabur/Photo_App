<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;



class UserController extends Controller
{
    /** mostrar todos los usuarios
     */
    public function index()
    {
        return response()->json(User::all(), 200) ;  
    }

    /**
     * crear un nuevo usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
            'role' => ['required', 'in:Client,Photographer'], 
            'profile_pic' => ['nullable', 'image', 'max:2048'], 
        ]);
        
        $user = User::create($validated);

        return response()->json($user, 201);
    }

    /**
     * Mostrar un usuario específico
     */
    public function show(string $id)
    {
        $user = User::fin($id);

        if (!$user) {
            return response()->json(['message'=>'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Actualizar el usuario en la bd.
     */
    public function update(Request $request, string $id)
    {
        $user = $request->user();
        
        // Si hay una nueva foto de perfil
        if ($request->hasFile('profile_pic')) {
            // Eliminar la foto antigua si existe
            if ($user->profile_pic) {
                Storage::delete($user->profile_pic->profile_pic);
            }

            // Subir la nueva foto
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            
            // Guardar la nueva foto de perfil en la base de datos
            $user->profile_pic()->updateOrCreate(
                ['user_id' => $user->id],
                ['profile_pic' => $path]
            );
        }
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message'=>'Usuario no encontrado'], 404);
        }
        $user->delete();
        return response()->json(['message'=>'Usuario eliminado correctamente', 200]);

    }
}
