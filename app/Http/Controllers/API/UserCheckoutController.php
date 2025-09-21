<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use Helpers;
use CartHelpers;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeVariation;
use App\Models\Order;
use App\Models\OrderItem;
use DB;

class UserCheckoutController extends BaseController
{
    public function index(Request $request)
    {
        $carts = CartHelpers::getCart(Auth::user()->id);

        if(count($carts) == 0)
        {
            return $this->sendError("Cart is empty", []);
        }

        foreach($carts as $cart)
        {
            $price[] = $cart['cart_variant_offer_price'] * $cart['cart_variant_quantity'];
        }

        $result['cart'] = $carts;
        $result['subtotal'] = array_sum($price);
        $result['delivery'] = 0;
        $result['tax'] = 0;
        return $this->sendResponse($result,'Order Summary.');
    }

    public function place_order(Request $request)
    {
        $rules = ['order_name' => 'required',
                    'order_email' => 'required|email',
                    'order_phone' => 'required',
                    'order_address'=> 'required',
                    'order_city' => 'required',
                    'order_state' => 'required',
                    'order_zip' => 'required|digits:6',
                    'order_pay_method' => 'required|digits:1',
                    'order_pay_status' => 'required|digits:1',
                    ];

        $messages = ['order_name.required'=>'Please provide name',
                    'order_email.required'=>'Please provide email',
                    'order_email.email'=>'Please provide valid email',
                    'order_phone.required'=>'Please provide Phone number',
                    'order_address.required'=>'Please provide Address',
                    'order_city.required'=>'Please provide City',
                    'order_state.required'=>'Please provide state',
                    'order_zip.required'=>'Please provide Zipcode',
                    'order_pay_method.required'=>'Please provide Payment Method',
                    'order_pay_status.required'=>'Please provide Payment Status',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $carts = CartHelpers::getCart(Auth::user()->id);

        if(count($carts) == 0)
        {
            return $this->sendError("Cart is empty", []);
        }

        foreach($carts as $cart)
        {
            $price[] = $cart['cart_variant_offer_price'] * $cart['cart_variant_quantity'];
        }

        $ordrcnt = Order::count();
        $id = $ordrcnt+1;

        $ins['order_refid']                = Helpers::generateCode('ORD',$id,5);
        $ins['order_company']              = $request->order_company;
        $ins['order_name']                 = $request->order_name;
        $ins['order_email']                = $request->order_email;
        $ins['order_phone']                = $request->order_phone;
        $ins['order_address']              = $request->order_address;
        $ins['order_address2']              = $request->order_address2;
        $ins['order_country']              = 1;
        $ins['order_city']                 = $request->order_city;
        $ins['order_state']                = $request->order_state;
        $ins['order_zip']                  = $request->order_zip;
        $ins['order_price']                = array_sum($price);
        $ins['order_total']                = array_sum($price);
        $ins['order_paid']                 = array_sum($price);
        $ins['order_payment']              = $request->order_pay_method;
        $ins['order_pay_status']           = $request->order_pay_status;
        $ins['order_added_by']             = Auth::user()->id;
        $ins['order_updated_by']           = Auth::user()->id;
        $ins['order_added_on']             = date('Y-m-d H:i:s');
        $ins['order_updated_on']            = date('Y-m-d H:i:s');

        $insert_id = Order::insertGetId($ins);
        {
            foreach($carts as $cart)
            {
                $ins_item['order_item_order'] = $insert_id;
                $ins_item['order_item_product'] = $cart['cart_product_id'];
                $ins_item['order_item_variant'] = $cart['cart_variant_id'];
                $ins_item['order_item_quantity'] = $cart['cart_variant_quantity'];
                $ins_item['order_item_price'] = $cart['cart_variant_offer_price'];

                $insert_item = OrderItem::create($ins_item);

                $variant = ProductVariant::find($cart['cart_variant_id']);
                $variant->product_variant_sale = $variant->product_variant_sale + $cart['cart_variant_quantity'];
                $variant->save();

                $ins_log['inventory_log_order']    = $insert_id;
                $ins_log['inventory_log_product']  = $cart['cart_product_id'];
                $ins_log['inventory_log_variant']  = $cart['cart_variant_id'];
                $ins_log['inventory_log_quantity'] = $cart['cart_variant_quantity'];
                $ins_log['inventory_log_message']  = "For order ID ".$ins['order_refid'];
                $ins_log['inventory_log_price']    = $cart['cart_variant_offer_price'];
                $ins_log['inventory_log_added_by'] = Auth::user()->id;
                $ins_log['inventory_log_added_on'] = date('Y-m-d H:i:s');

                $log = DB::table('inventory_logs')->insert($ins_log);

            }

            CartHelpers::clear(Auth::user()->id);
        }

        $result['order_id'] = $ins['order_refid'];
        return $this->sendResponse($result,'Order Placed.');

    }

}
