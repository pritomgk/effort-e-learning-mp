<?php

namespace Database\Seeders;

use App\Models\Member_user;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

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
            'balance' => '2000000',
            'user_code' => '240001',
            'presenter_id' => 1,
            'cp_id' => 1,
            'executive_id' => 1,
            'eo_id' => 1,
            'seo_id' => 1,
            'director_id' => 1,
            'dg_id' => 1,
            'cp_approval' => 1,
            'role_id' => 11,
            'status' => 1,
            'password' => Hash::make('Pritomgk@12#'),
        ]);
        
        $faker = Faker::create();

        for ($i=0; $i < 50; $i++) { 
            $member = new Member_user();

            $member->name = $faker->name;
            $member->phone = $faker->phoneNumber;
            $member->email = $faker->email;
            $member->email_verified = 1;
            $member->verify_token = $faker->numberBetween(100000, 999999);
            $member->whatsapp = $faker->phoneNumber;
            $member->gender = 'm';
            $member->home_town = $faker->city();
            $member->city = $faker->city();
            $member->country = $faker->country;
            $member->balance = '';
            $member->country = $faker->country;
            $member->user_code = 24000000+$i;
            $member->parent_user_code = 24000001;
            $member->role_id = 11;
            $member->password = $faker->password;
            $member->save();
        }
        
    }
}


