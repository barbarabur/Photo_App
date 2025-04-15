<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PhotoTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las fotos y tags existentes
        $photos = Photo::all();
        $tags = Tag::all();

        // Asociar tags a fotos
        foreach ($photos as $photo) {
            $tagsToAttach = $tags->random(rand(1, 5))->pluck('id');
            $photo->tags()->attach($tagsToAttach);
        }
    }
}
