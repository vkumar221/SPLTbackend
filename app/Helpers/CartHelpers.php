<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Str;
use DB;
use Auth;
use Mail;
use Log;
use Exception;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeVariation;
use App\Models\Cart;

class CartHelpers
{
    public static function getCart($user)
    {
        $carts = Cart::getDetails(['cart_user'=>$user]);

        if($carts->count() > 0)
        {
            $attris = AttributeVariation::getDetails(['attribute_variation_trash'=>0]);
            foreach($attris as $attri)
            {
                $att_var[$attri->attribute_variation_id][$attri->attribute_name] = $attri->attribute_variation_value;
            }

            foreach($carts as $key => $cart)
            {
                if($cart->product_variant_attribute != NULL)
                {
                    $attributes = json_decode($cart->product_variant_attribute,true);
                }
                $car[$key]['cart_id'] = $cart->cart_id;
                $car[$key]['cart_product_id'] = $cart->product_id;
                $car[$key]['cart_product_name'] = $cart->product_name;
                $car[$key]['cart_product_image'] = asset(config('constants.admin_path').'uploads/product/'.$cart->product_image);
                $car[$key]['cart_variant_id'] = ($cart->product_variant_id != NULL) ? $cart->product_variant_id : 0;
                $car[$key]['cart_variant_name'] = ($cart->product_variant_name != NULL) ? $cart->product_variant_name : '';
                $car[$key]['cart_product_variant_image'] = ($cart->product_variant_image != NULL) ? asset(config('constants.admin_path').'uploads/product/'.$cart->product_variant_image) : '';
                $car[$key]['cart_variant_price'] = ($cart->product_variant_price != NULL) ? $cart->product_variant_price : '';
                $car[$key]['cart_variant_offer_price'] = ($cart->product_variant_offer_price != NULL) ? $cart->product_variant_offer_price : '';
                $car[$key]['cart_variant_quantity'] = $cart->cart_quantity;

                if($cart->product_variant_attribute != NULL)
                {
                    foreach($attributes as $attribute)
                    {
                        foreach($att_var[$attribute] as $name => $value)
                        {
                            $car[$key]['cart_variant_attributes'][$name] = $value;
                        }

                    }
                }
                else
                {
                    $car[$key]['cart_variant_attributes'] = [];
                }
            }

            return $car;
        }
        else
        {
            $car = [];
             return $car;
        }
    }

    public static function clear($user)
    {
        $delete = Cart::where(['cart_user'=>$user])->delete();

        return true;

    }
}
