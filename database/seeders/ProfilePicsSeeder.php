<?php

namespace Database\Seeders;

use App\Models\Profile_pic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfilePic;
use Faker\Factory as Faker;


class ProfilePicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //obtener todos los usuarios sin foto de perfil
        $users = User::whereDoesntHave('profile_pic')->get();

       

        foreach ($users as $user) {
            $imageNumber = rand(1,70);
            $imageUrl = "https://i.pravatar.cc/300?img={$imageNumber}";

            Profile_pic::create([
                'user_id'=>$user->id,
                'profile_pic'=>$imageUrl,
            ]);
        }
    }
}
