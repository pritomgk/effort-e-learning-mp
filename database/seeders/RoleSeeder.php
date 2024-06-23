<?php

namespace Database\Seeders;

use App\Models\User_role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User_role::create([
            'role_title' => 'Director General',
        ]);
        
        User_role::create([
            'role_title' => 'Director',
        ]);

        User_role::create([
            'role_title' => 'CEO',
        ]);

        User_role::create([
            'role_title' => 'SEO',
        ]);

        User_role::create([
            'role_title' => 'Executive Officer',
        ]);

        User_role::create([
            'role_title' => 'Executive',
        ]);

        User_role::create([
            'role_title' => 'Chief Presenter',
        ]);

        User_role::create([
            'role_title' => 'Presenter',
        ]);

        User_role::create([
            'role_title' => 'Head Teacher',
        ]);

        User_role::create([
            'role_title' => 'Teacher',
        ]);

        User_role::create([
            'role_title' => 'Member',
        ]);

    }
}


