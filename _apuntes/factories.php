<?php
//Los factories sirven para generar datos. Esos datos se pueden usar para rellenar un seeder, usarlos en un controlador, en los tests, etc


//php artisan make:factory PhotoFactory--model=Photo
use App\Models\Photo;
use App\Models\User; //porque tiene una relacion y lo vamos a usar

class PhotoFactory extends Factory
{
protected $model = Photo::class; //especifica que este factory es para el modelo photo

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'url' => 'photos/' . fake()->unique()->uuid . '.jpg',
            'price' => fake()->randomFloat(2, 5, 100),
            'user_id' => User::factory(), // Relación con el fotógrafo
        ];
    }

    // Estados opcionales por si queremos hacer fotos tipo free o premium
    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => 0.00
        ]);
    }

    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->randomFloat(2, 100, 500)
        ]);
    }

}

?>