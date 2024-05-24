<?php

namespace Database\Seeders;

use App\Models\Admin_user;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin_user::create([
            'name' => 'Pritom GK',
            'phone' => '0000',
            'email' => 'pritomguha62@gmail.com',
            'email_verified' => 1,
            'verify_token' => 657434,
            'whatsapp' => 0000,
            'gender' => 1,
            'balance' => 200000000,
            'status' => 1,
            'parent_id' => 1,
            'user_code' => 240001,
            'parent_user_code' => 240001,
            'role_id' => 1,
            'password' => Hash::make('Pritomgk@12#'),
        ]);

        // Admin_user::create([
        //     'name' => 'Holy It',
        //     'phone' => '0001',
        //     'email' => 'holy.it01@gmail.com',
        //     'email_verified' => 1,
        //     'verify_token' => 657434,
        //     'whatsapp' => 0001,
        //     'gender' => 1,
        //     'balance' => 200000000,
        //     'status' => 1,
        //     'parent_id' => 1,
        //     'user_code' => 1,
        //     'parent_user_code' => 1,
        //     'role_id' => 1,
        //     'password' => Hash::make('Holyit@1990'),
        // ]);
        
    }
}


