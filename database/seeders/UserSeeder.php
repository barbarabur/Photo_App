<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // Crear roles si no existen
    $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $photographerRole = Role::firstOrCreate(['name' => 'photographer', 'guard_name' => 'web']);
    $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);


    // Usuario administrador predeterminado
        $admin = User::factory()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ])->assignRole('admin');


   // Crear 5 fotógrafos
        $photographers = User::factory()
            ->count(5)
            ->photographer() // Usa la factory 
            ->create()
            ;
       

        // Crear 15 clientes
        $clients = User::factory()
            ->count(15)
            ->client()
            ->create()
            ;
       
       
        
    }
}
