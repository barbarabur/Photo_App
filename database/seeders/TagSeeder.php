<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;


class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //lista de tags
        $tags = [
            'retrato',
            'paisaje',
            'urbano',
            'naturaleza',
            'animales',
            'viajes',
            'comida',
            'deporte',
            'arte',
            'moda',
            'arquitectura',
            'blanco y negro',
            'abstracto',
            'macro',
            'nocturna',
            'playa',
            'montaña',
            'bodas',
            'eventos',
            'producto'
        ];

        //insertar tags en la bd
        foreach ($tags as $tag) {
            Tag::create([
                'tag'=> $tag
            ]);

        }
        $this->command->info('Tags creados: '.count($tags));

    }
}
