<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PhotoSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call ([
            RoleSeeder::class,
            UserSeeder::class,
            ProfilePicsSeeder::class,
            TagSeeder::class,
            PhotoSeeder::class,
            OrderSeeder::class,
            OrderPhotoSeeder::class,
            PaymentSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class,
            PhotoTagSeeder::class,
        ]);
    }
}
