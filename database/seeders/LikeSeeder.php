<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;


class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //obtener fotos y usuarios 
        $photos = Photo::all();
        $users = User::all();
        $photographers = User::role('photographer');

       // Crear likes para fotos
       foreach ($photos as $photo) {
            // Determinar cuántos usuarios darán like a esta foto (entre 3 y 10)
            $likeCount = rand(3, min(10, $users->count()));
            
            // Seleccionar usuarios aleatorios
            $randomUsers = $users->random($likeCount);
            
            foreach ($randomUsers as $user) {
                Like::firstOrCreate([
                    'user_id'=>$user->id,
                    'likeable_id'=>$photo->id,
                    'likeable_type'=>Photo::class,
                ]);
            }
       }
        //crear likes entre usuarios
        
        foreach ($users as $user) {
            // Determinar a cuántos usuarios seguirá (entre 2 y 5)
            $followCount = rand(2, 5);
            
            // Seleccionar usuarios aleatorios (excluyéndose a sí mismo)
            $usersToFollow = $users->where('id', '!=', $user->id)
                                 ->random($followCount);
            
            foreach ($usersToFollow as $userToFollow) {
                Like::firstOrCreate([
                    'user_id' => $user->id,
                    'likeable_id' => $userToFollow->id,
                    'likeable_type' => User::class,
                ]);
            }
        }
        
    
    }
}
