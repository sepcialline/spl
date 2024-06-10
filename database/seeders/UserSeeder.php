<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker=Faker::create();
        // for ($i=0; $i < 50; $i++) {
        //     # code...
        //     $user = User::create([
        //         'name' => $faker->name(),
        //         'email' => $faker->email(),
        //         'mobile' => $faker->e164PhoneNumber(),
        //         'password' => bcrypt('010203'),
        //         'emirate_id' => '1',
        //         'city_id' => '1',
        //         'status' => '1',
        //         'address' => $faker->address(),
        //         'longitude' => $faker->longitude(),
        //         'latitude' => $faker->latitude(),
        //         'photo' => 'avatar.png',
        //     ]);
        // }

        // $user->assignRole('Super Admin');

    }
}