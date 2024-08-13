<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::truncate();

        $faker = Factory::create();

        User::all()->each(function ($user) use ($faker) {
            foreach (range(1, 5) as $i) {
                Task::create([
                    'user_id' => $user->id,
                    'name'   => $faker->sentence,
                ]);
            }
        });

    }
}
