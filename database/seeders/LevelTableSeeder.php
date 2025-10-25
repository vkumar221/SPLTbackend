<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('levels')->count();

        if($count == 0)
        {
            $level = [
            ['level_name' => 'Level 1'],
            ['level_name' => 'Level 2'],
            ['level_name' => 'Level 3'],
            ['level_name' => 'Level 4'],
            ];

            DB::table('levels')->insert($level);
        }

    }
}
