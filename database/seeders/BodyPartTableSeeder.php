<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class BodyPartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('body_parts')->count();

        if($count == 0)
        {
            $body_part = [
            ['body_part_name' => 'Abdomen'],
            ['body_part_name' => 'Body Fat'],
            ['body_part_name' => 'Body Weight'],
            ['body_part_name' => 'Chest'],
            ['body_part_name' => 'Hips'],
            ['body_part_name' => 'Left Bicep'],
            ['body_part_name' => 'Left Calf'],
            ['body_part_name' => 'Left Forearm'],
            ['body_part_name' => 'Left Thight'],
            ['body_part_name' => 'Neck'],
            ['body_part_name' => 'Right Bicep'],
            ['body_part_name' => 'Right Calf'],
            ['body_part_name' => 'Chest'],
            ['body_part_name' => 'Right Forearm'],
            ['body_part_name' => 'Right Thigh'],
            ['body_part_name' => 'Shoulder'],
            ['body_part_name' => 'Waist']
            ];

            DB::table('body_parts')->insert($body_part);
        }

    }
}
