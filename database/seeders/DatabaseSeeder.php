<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ExerciseSeeder::class,
            ComplaintSeeder::class,
            GoalSeeder::class,
            ComplaintExerciseSeeder::class,
            GoalExerciseSeeder::class,
            AdminSeeder::class,  // ← tambahkan
        ]);
    }
}
