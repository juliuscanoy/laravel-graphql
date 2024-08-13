<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        
        User::truncate();

        $faker = Factory::create();
        $password = bcrypt('secret');

        User::create([
            'name'     => $faker->name,
            'email'    => 'graphql@example.com',
            'password' => $password,
        ]);

        for ($i = 0; $i < 10; ++$i) {
            User::create([
                'name'     => $faker->name,
                'email'    => $faker->email,
                'password' => $password,
            ]);
        }

        
    }
}
