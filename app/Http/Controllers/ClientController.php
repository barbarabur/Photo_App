<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;


class ClientController extends Controller
{
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

    public function photosParaMain() {
        $photos = Photo::latest()->take(12)->get();

        return view ('clients.mainClient', compact('photos'));
    }

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
    public function index()
    {
        $photos = Photo::latest()->take(12)->get();

        return view ('clients.mainClient', compact('photos'));
    }
}
