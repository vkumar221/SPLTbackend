<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use CartHelpers;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeVariation;
use App\Models\Cart;

class UserCartController extends BaseController
{
    public function index(Request $request)
    {
        $carts = Cart::getDetails(['cart_user'=>Auth::user()->id]);

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

            $result['cart'] = $car;
            return $this->sendResponse($result,'Cart list is fetched.');
        }
        else
        {
             return $this->sendResponse([],"Cart is Empty");
        }
    }

    public function add_cart(Request $request)
    {

        $rules = ['product_id' => 'required|numeric',
                    'quantity' => 'required|numeric',
                    'variant_id' => 'required|numeric'];

        $messages = ['product_id.required'=>'Please provide product id',
                     'quantity.required'=>'Please enter quantity',
                     'variant_id.required'=>'Please enter variant id'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        $product_id = $request->product_id;
        $variant_id = $request->variant_id;
        $quantity = $request->quantity;

        $product = Product::where('product_id',$product_id)->first();
        if(isset($product))
        {
            if($variant_id != 0)
            {
                $product_variant = ProductVariant::where(['product_variant_id'=>$variant_id,'product_variant_product'=>$product_id])->first();

                if(!isset($product_variant))
                {
                    return $this->sendError("No Variant Found", []);
                }
                else
                {
                    $carts = Cart::where(['cart_product'=>$product_id,'cart_variant'=>$variant_id,'cart_user'=>Auth::user()->id])->get();

                    if($carts->count() == 0)
                    {
                        $ins['cart_product']     = $product_id;
                        $ins['cart_name']        = $product->product_name;
                        $ins['cart_offer_price'] = $product->product_offer_price;
                        $ins['cart_price']       = $product->product_price;
                        $ins['cart_quantity']    = $quantity;
                        $ins['cart_variant']     = $variant_id;
                        $ins['cart_user']        = Auth::user()->id;
                        $ins['cart_added_by']    = Auth::user()->id;
                        $ins['cart_added_on']    = date('Y-m-d H:i:s');
                        $ins['cart_updated_by']  = Auth::user()->id;
                        $ins['cart_updated_on']  = date('Y-m-d H:i:s');

                        $insert = Cart::create($ins);
                    }
                    else
                    {
                        $cart = $carts->first();
                        $upd['cart_quantity'] = $cart->cart_quantity + $quantity;
                        $upd['cart_updated_by']  = Auth::user()->id;
                        $upd['cart_updated_on']  = date('Y-m-d H:i:s');

                        $update = Cart::where('cart_id',$cart->cart_id)->update($upd);
                    }

                }
            }
            $result['cart'] = CartHelpers::getCart(Auth::user()->id);
            return $this->sendResponse($result,'Added to cart.');
        }

    }

    public function update_cart(Request $request)
    {
        $rules = ['product_id' => 'required|numeric',
                    'quantity' => 'required|numeric',
                    'variant_id' => 'required|numeric'];

        $messages = ['product_id.required'=>'Please provide product id',
                     'quantity.required'=>'Please enter quantity',
                     'variant_id.required'=>'Please enter variant id'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        $product_id = $request->product_id;
        $variant_id = $request->variant_id;
        $quantity = $request->quantity;

        $carts = Cart::where(['cart_product'=>$product_id,'cart_variant'=>$variant_id,'cart_user'=>Auth::user()->id])->get();

        if($carts->count() > 0)
        {
            $cart = $carts->first();
            $upd['cart_quantity']    = $quantity;
            $upd['cart_updated_by']  = Auth::user()->id;
            $upd['cart_updated_on']  = date('Y-m-d H:i:s');

            $update = Cart::where('cart_id',$cart->cart_id)->update($upd);

            $result['cart'] = CartHelpers::getCart(Auth::user()->id);
            return $this->sendResponse($result,'Cart Updated');
        }
        else
        {
            return $this->sendError("Product not found in the cart", []);
        }




    }

    public function remove_cart(Request $request)
    {
        $rules = ['product_id' => 'required|numeric',
                    'variant_id' => 'required|numeric'];

        $messages = ['product_id.required'=>'Please provide product id',
                     'variant_id.required'=>'Please enter variant id'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        $product_id = $request->product_id;
        $variant_id = $request->variant_id;

        $carts = Cart::where(['cart_product'=>$product_id,'cart_variant'=>$variant_id,'cart_user'=>Auth::user()->id])->get();

        if($carts->count() > 0)
        {
            $delete = Cart::where(['cart_product'=>$product_id,'cart_variant'=>$variant_id,'cart_user'=>Auth::user()->id])->delete();

            return $this->sendResponse([],'Cart Item Removed');
        }
        else
        {
            return $this->sendError("Product not found in the cart", []);
        }

    }

    public function clear_cart(Request $request)
    {
        $delete = Cart::where(['cart_user'=>Auth::user()->id])->delete();

        return $this->sendResponse([],'Cart Cleared');

    }
}
