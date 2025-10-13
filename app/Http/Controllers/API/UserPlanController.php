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

    public function buy_plan(Request $request)
    {
        $rules = [
                    'plan_id' => 'required',
                    'plan_type' => 'required',
                    'trainer_id' => 'required',
                    'payment_method' => 'required|numeric',
                ];

        $messages = [
                     'plan_id.required' => 'Please Provide Plan Id',
                     'plan_type.required' => 'Please Provide Plan Type',
                     'trainer_id.required' => 'Please Provide Trainer Id',
                     'payment_method.required' => 'Please Provide Payment Method',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $plan = SubscriptionPlan::where('subscription_plan_id',$request->plan_id)->first();

            $ins['user_plan']         = $request->plan_id;
            $ins['user_plan_type']    = $request->plan_type;
            $ins['user_plan_price']   = ($request->plan_type == 1) ? $plan->subscription_plan_price : (($plan->subscription_plan_price * 12)*0.75);
            $ins['user_plan_payment'] = $request->payment_method;
            $ins['user_plan_type']    = $request->plan_type;
            $ins['user_plan_user']    = Auth::user()->id;
            $ins['user_plan_expiry']  = Helpers::getPlanExpiryDate($request->plan_type);
            $ins['user_plan_added_by']    = Auth::user()->id;
            $ins['user_plan_updated_by']  = Auth::user()->id;
            $ins['user_plan_added_on']    = date('Y-m-d H:i:s');
            $ins['user_plan_updated_on']  = date('Y-m-d H:i:s');

            $insert = UserPlan::create($ins);

            if($insert)
            {
                $insTr['trainer_client'] = Auth::user()->id;
                $insTr['trainer_client_trainer'] = $request->trainer_id;

                DB::table('trainer_clients')->inser($insTr);
            }

        }


    }

}
