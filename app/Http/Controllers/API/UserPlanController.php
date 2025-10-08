<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use DB;
use App\Models\User;
use App\Models\SubscriptionPlan;

class UserPlanController extends BaseController
{
    public function index(Request $request)
    {
        $plans = SubscriptionPlan::where(['subscription_plan_status'=>1,'subscription_plan_trash'=>0])->get();
        $items = DB::table('subscription_plan_items')->join('plan_items','plan_items.plan_item_id','subscription_plan_items.subscription_plan_item')->get();
        foreach($items as $key => $item)
        {
            $itm[$item->subscription_plan_item_plan][] = $item->plan_item_name;
        }
        $pln = array();
        foreach($plans as $key => $plan)
        {
            $pln[$key]['plan_id'] = $plan->subscription_plan_id;
            $pln[$key]['plan_name'] = $plan->subscription_plan_title;
            //$pln[$key]['plan_image'] = asset(config('constants.admin_path').'uploads/subscription_plan/'.$plan->subscription_plan_image);
            $pln[$key]['plan_price'] = config('constants.currency_symbol').' '.$plan->subscription_plan_price;
            $pln[$key]['plan_price_annual'] = config('constants.currency_symbol').' '.(($plan->subscription_plan_price * 12)*0.75);
            $pln[$key]['plan_popular'] = ($plan->subscription_plan_popular == 1) ? 'No' : 'Yes';
            $pln[$key]['plan_description'] = $plan->subscription_plan_description;
            if(isset($itm[$plan->subscription_plan_id]))
            {
                foreach($itm[$plan->subscription_plan_id] as $vkey =>$itms)
                {
                    $pln[$key]['inclusion'][$vkey] = $itms;
                }
            }
            else
            {
                $pln[$key]['inclusion'] = [];
            }
        }
        $result['plans'] = $pln;
        return $this->sendResponse($result, 'Plan List Fetched Successfully.');
    }

}
