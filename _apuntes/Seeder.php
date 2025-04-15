<?php

/**
 * Estructura básica que si no se ha creado con el modelo, 
 * se crea con php artisan make:seeder NombreensingularSeeder
 * Para datos que se introducen desde el principio en la base de datos
 */

//php artisan make:seeder PhotoSeeder


# Ejecutar solo el seeder de fotos
php artisan db:seed --class=PhotoSeeder

# Ejecutar todo el sistema de seeders
php artisan db:seed

# Refrescar toda la base de datos con datos de prueba
php artisan migrate:fresh --seed


 // En databaseSeeder incluimos los seeders que queremos que se ejecuten

 public function run() {
    User::factory(3)->create();
    $this->call([
        loqueseaSeeder::class,
        PhotoSeeder::class,
    ])
 }




namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
----> ojo con esto use App\Models\nombreModelo;            !!!!!!!

class nombreModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crear usuario  manualmente
        User::create([
            'name'=>'pepe',
            'email'=>'pepe@exampl.com',
            'password'=>'pepe123',
            'role'=>'photographer'
        ]);
    }
}




// Relacionar fotos con tags N:M sin pivot
        
$photos = Photo::all();
$tags = \App\Models\Tag::all();

$photos->each(function($photo) use ($tags) {
    $photo->tags()->attach(
        $tags->random(rand(1,3))->pluck('id')
    );
});

//para hacer el factory

namespace Database\Factories;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    protected $model = Photo::class; //especifica que este factory es para el modelo photo

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' =>fake()->sentence(3),
            'description'=>fake()->paragraph(),
            'url'=>'photos/' . fake()->unique()->uuid. '.jpg',
            'user_id'=> User::factory(), //relación con el fotógrafo
        ];
    }
   
    
}