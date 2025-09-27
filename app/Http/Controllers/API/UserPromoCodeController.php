<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\PromoCode;
use App\Models\Order;

class UserPromoCodeController extends BaseController
{
    public function index(Request $request)
    {
        $promocodes = PromoCode::where('promo_code_status',1)->get();
        if(isset($promocodes))
        {
            foreach($promocodes as $key=> $promocode)
            {
                $promo[$key]['promo_code_id'] = $promocode->promo_code_id;
                $promo[$key]['promo_code_name'] = $promocode->promo_code_name;
                $promo[$key]['image'] = asset(config('constants.admin_path').'uploads/promo_code/'.$promocode->promo_code_image);
                $promo[$key]['type'] = ($promocode->promo_code_type == 1) ? 'Fixed Amount' : 'Percentage' ;
                $promo[$key]['value'] = $promocode->promo_code_value;
                $promo[$key]['discount_upto'] = $promocode->promo_code_max_order_value;
                $promo[$key]['min_order'] = $promocode->promo_code_min_order_value;
                $promo[$key]['from'] = $promocode->promo_code_from;
                $promo[$key]['to'] = $promocode->promo_code_to;
                $promo[$key]['repeat_usage'] = $promocode->promo_code_usage;
                $promo[$key]['max_users'] = $promocode->promo_code_max_users;

            }
            $result['promo_codes'] = $promo;
            return $this->sendResponse($result,'Promo code List.');
        }
        else
        {
            return $this->sendError("No Promo code found", []);
        }

    }

    public function verify_promocode(Request $request)
    {
        $rules = ['order_value' => 'required',
                    'promocode' => 'required',
                    ];

        $messages = ['order_value.required'=>'Please enter order value',
                    'promocode.required'=>'Please provide promocode'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $coupon = PromoCode::where('promo_code_name',$request->promocode)->first();

        $date = strtotime(date('Y-m-d'));
        if(!isset($coupon))
        {
            return $this->sendError([], ['error'=>'Promo code not found']);
        }
        else
        {
            $orders = Order::where(['order_added_by'=>Auth::user()->id,'order_coupon'=>$coupon->promo_code_id])->get();
            $order_count = Order::where(['order_coupon'=>$coupon->promo_code_id])->count();
            $result['promocode'] = $coupon->promo_code_name;
            $result['discount_value'] = $coupon->promo_code_value;
            $result['discount_type'] = ($coupon->promo_code_type == 1) ? 'Fixed Amount' : 'Percentage';

            $from = strtotime($coupon->promo_code_from);
            $to = strtotime($coupon->promo_code_to);

           if($date >= $from && $date <= $to)
           {
                if($orders->count() < $coupon->promo_code_usage)
                {
                    if($order_count < $coupon->promo_code_max_users)
                    {
                        if($request->order_value >= $coupon->promo_code_min_order_value)
                        {
                            if($coupon->promo_code_type == 2)
                            {
                                if($request->order_value > $coupon->promo_code_max_order_value)
                                {
                                    $price = $coupon->promo_code_max_order_value;
                                }
                                else
                                {
                                    $price = $request->order_value;
                                }

                                $discount = round((($price * $coupon->promo_code_value)/100),2);
                                $final = $request->order_value - $discount;
                            }
                            else
                            {
                                $discount = $coupon->promo_code_value;
                                $final = $request->order_value - $discount;
                            }

                            $result['applied_discount'] = $discount;
                            $result['final_value'] = $final;

                            return $this->sendResponse($result,'Promo code Applied.');
                        }
                        else
                        {
                            return $this->sendError([], ['error'=>'This promo code requires a minimum order value of '.$coupon->promo_code_min_order_value.'. Please add more items to your cart to apply it.']);
                        }
                    }
                    else
                    {
                        return $this->sendError([], ['error'=>'This promo code has reached its usage limit and can no longer be applied.']);
                    }
                }
                else
                {
                    return $this->sendError([], ['error'=>'You have reached the maximum usage of this promo code']);
                }
           }
           else
           {
                return $this->sendError([], ['error'=>'This promo code is expired']);
           }

        }
    }

}
