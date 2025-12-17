<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\RoleEnum;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        
        User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            
        ])->syncRoles([RoleEnum::ADMIN]);
    }
}
