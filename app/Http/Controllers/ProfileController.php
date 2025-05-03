<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Profile_pic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        Log::info('Navegación: Se accedió al formulario de edición de usuario.', ['user_id' => $request]);

        $user = $request->user();

        // Obtener la foto de perfil del usuario desde la relación Profile_pic
        $profilePic = $user->profile_pic ? 
                  Storage::url($user->profile_pic->profile_pic) : 
                  'profile_pics/default.png';

        return view('profile.edit', [
            'user' => $user,
            'profilePic' => $profilePic,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
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

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
