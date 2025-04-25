<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Photo;

class CountPhotoViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $photoId = $request->route('id')?? $request->route('photo');
        $photo = Photo::find($photoId);
        if ($photo) {
            $sessionKey = 'viewed_photo_'.$photoId;

            if(!session()->has($sessionKey)) {
                $photo->increment('views');
                session()->put($sessionKey);
            }

        }
        return $next($request);
    }
}
