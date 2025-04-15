<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\User;
use Faker\Factory as Faker;


class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        //obtener los users con rol photographer
        $photographerIds = User::role('photographer')->pluck('id')->toArray();

        foreach ($photographerIds as $photographerId) {
            $photoCount = rand (5,10);
            $imageNumber = rand(10,100);

            for ($i=0; $i<$photoCount; $i++) {
                $imageNumber = rand(10,100);
                $imageUrl = "https://picsum.photos/id/{$imageNumber}/200/300";

                Photo::create([
                    'title' => 'Picture number'. $imageNumber,
                    'description' => $faker->paragraph(2),
                    'url' => $imageUrl,
                    'price'=> fake()->randomFloat(2,20,200),
                    'user_id' => $photographerId
                ]);

            }
        }

        
        // 2. Relacionar fotos con tags N:M sin pivot
        
        $photos = Photo::all();
        $tags = \App\Models\Tag::all();
    
        $photos->each(function($photo) use ($tags) {
            $photo->tags()->attach(
                $tags->random(rand(1,3))->pluck('id')
            );
        });


        $this->command->info('Fotos creadas: ' . Photo::count());
    }

}
