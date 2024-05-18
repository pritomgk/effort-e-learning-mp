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
            'role_title' => 'director_general',
        ]);
        
        User_role::create([
            'role_title' => 'director',
        ]);

        User_role::create([
            'role_title' => 'ceo',
        ]);

        User_role::create([
            'role_title' => 'seo',
        ]);

        User_role::create([
            'role_title' => 'executive_officer',
        ]);

        User_role::create([
            'role_title' => 'executive',
        ]);

        User_role::create([
            'role_title' => 'chief_presenter',
        ]);

        User_role::create([
            'role_title' => 'presenter',
        ]);

        User_role::create([
            'role_title' => 'head_teacher',
        ]);

        User_role::create([
            'role_title' => 'teacher',
        ]);

        User_role::create([
            'role_title' => 'member',
        ]);

    }
}


