<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class PlanItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('plan_items')->count();

        if($count == 0)
        {
            $plan_items = [
                ['plan_item_name' => 'Access to workout library', 'plan_item_route' => 'user.library'],
                ['plan_item_name' => 'Track sets, reps, weights', 'plan_item_route' => 'user.sets'],
                ['plan_item_name' => 'Smart rest timer', 'plan_item_route' => 'user.timer'],
                ['plan_item_name' => 'Weekly progress reports', 'plan_item_route' => 'user.report'],
                ['plan_item_name' => 'Sync with Apple Health / Google Fit', 'plan_item_route' => 'user.sync'],
                ['plan_item_name' => 'Unlock premium training programs', 'plan_item_route' => 'user.programs'],
                ['plan_item_name' => 'Meal & nutrition tracking', 'plan_item_route' => 'user.nutrition'],
                ['plan_item_name' => 'Exclusive challenges & leaderboards', 'plan_item_route' => 'user.challenges'],
            ];

            DB::table('plan_items')->insert($plan_items);
        }

    }
}
