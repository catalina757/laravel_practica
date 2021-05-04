<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($i = 0; $i < 10; $i++) {
            Task::create([
                'subject' => $faker->realText(30),
                'description' => $faker->realText(200),
                'user_id' => User::inRandomOrder()->first()->id,
                'assign_id' => User::inRandomorder()->first()->id,
            ]);
        }

    }
}
