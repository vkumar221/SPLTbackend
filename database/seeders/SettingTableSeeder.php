<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('settings')->count();

        if($count == 0)
        {
            $setting = [
            ['setting_name' => 'SPLT','setting_email' => 'support@splt.com','setting_phone'=>'1234567890'],
            ];

            DB::table('settings')->insert($setting);
        }

    }
}
