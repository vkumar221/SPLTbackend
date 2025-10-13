<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class GoalTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('goal_types')->count();

        if($count == 0)
        {
            $goal_type = [
            ['goal_type_name' => 'Lose Weight'],
            ['goal_type_name' => 'Build Muscle'],
            ['goal_type_name' => 'Increase Strength'],
            ['goal_type_name' => 'Improve Endurance'],
            ['goal_type_name' => 'Mobility and Flexibility'],
            ['goal_type_name' => 'General Fitness / Stay Healthy'],
            ['goal_type_name' => 'Sport Performance'],
            ['goal_type_name' => 'Mental Well-being / Stress Relief'],
            ['goal_type_name' => 'Rehabilitation / Recovery']
            ];

            DB::table('goal_types')->insert($goal_type);
        }

    }
}
