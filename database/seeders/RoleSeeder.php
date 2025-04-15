<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        $roles = ['photographer', 'admin', 'customer'];
        
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => 'photographer', 'guard_name' => 'web']);
        }
    }
}
