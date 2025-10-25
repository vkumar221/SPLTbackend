<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('faqs')->count();

        if($count == 0)
        {
            $faq = [
            ['faq_question' => 'How to create Workout','faq_answer' => '1- Go to your workouts page from the navigation bar']
            ];

            DB::table('faqs')->insert($faq);
        }

    }
}
