<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //obtener usuarios y fotos existentes
        $users = User::all();
        $photos = Photo::all();

        //crear comentarioas para fotos
        $photos->each(function ($photo) use ($users){
            Comment::factory()
                ->count(rand(1,3))
                ->create([
                    'user_id'=>$users->random()->id,
                    'commentable_id'=>$photo->id,
                    'commentable_type' => Photo::class,
                ]);
        });

        //crear comentarios en otros comentarios
        $comments = Comment::all();

        $comments->each(function ($comment) use ($users) {
            if (rand(0, 1)) { // 50% de probabilidad de tener respuestas
                Comment::factory()
                    ->count(rand(1, 2))
                    ->create([
                        'user_id' => $users->random()->id,
                        'commentable_id' => $comment->id,
                        'commentable_type' => Comment::class,
                    ]);
            }
        });
    }
}
