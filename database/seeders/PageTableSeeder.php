<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('pages')->count();

        if($count == 0)
        {
            $page = [
            ['page_title' => 'Terms and Conditions','page_content' => 'Terms and Conditions'],
            ['page_title' => 'About Us','page_content' => 'About Us'],
            ];

            DB::table('pages')->insert($page);
        }

    }
}
