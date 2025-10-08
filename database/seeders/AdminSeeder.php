<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $count = DB::table('admins')->count();

        if($count == 0)
        {

            DB::table('admins')->insert([
                'admin_name'       => 'Admin',
                'admin_image'      => NULL,
                'admin_mobile'     => '9876543210',
                'admin_email'      => 'admin@example.com',
                'admin_password'   => Hash::make('123456'),
                'admin_vpassword'  => base64_encode('123456'), // Consider removing this column
                'admin_role'       => 1,
                'admin_address'    => '123 Admin Street, Tech City',
                'admin_added_on'   => Carbon::now(),
                'admin_added_by'   => 1,
                'admin_updated_on' => Carbon::now(),
                'admin_updated_by' => 1,
                'admin_status'     => 1,
            ]);
        }
    }
}
