<?php

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
