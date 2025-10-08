<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('countries')->count();

        if($count == 0)
        {

                $countries = [
                ['country_name' => 'India', 'country_code' => 'IN'],
                ['country_name' => 'United States', 'country_code' => 'US'],
                ['country_name' => 'United Kingdom', 'country_code' => 'GB'],
                ['country_name' => 'Canada', 'country_code' => 'CA'],
                ['country_name' => 'Australia', 'country_code' => 'AU'],
                ['country_name' => 'Germany', 'country_code' => 'DE'],
                ['country_name' => 'France', 'country_code' => 'FR'],
                ['country_name' => 'Japan', 'country_code' => 'JP'],
                ['country_name' => 'China', 'country_code' => 'CN'],
                ['country_name' => 'Brazil', 'country_code' => 'BR'],
            ];

            DB::table('countries')->insert($countries);
        }

    }
}
