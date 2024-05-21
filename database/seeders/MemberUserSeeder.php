<?php

namespace Database\Seeders;

use App\Models\Member_user;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member_user::create([
            'name' => 'Pritom GK',
            'phone' => '01',
            'email' => 'pritomguha62@gmail.com',
            'email_verified' => 1,
            'verify_token' => 353434,
            'whatsapp' => '01',
            'gender' => 'm',
            'home_town' => 'sdsdf',
            'city' => 'fslj',
            'country' => 'BD',
            'balance' => '',
            'user_code' => '5565',
            'presenter_id' => 11,
            'cp_id' => 11,
            'executive_id' => 11,
            'eo_id' => 11,
            'seo_id' => 11,
            'director_id' => 11,
            'dg_id' => 11,
            'cp_approval' => 1,
            'role_id' => 11,
            'status' => 1,
            'password' => Hash::make('Pritomgk@12#'),
        ]);
    }
}


