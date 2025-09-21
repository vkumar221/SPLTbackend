<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeVariation;

class UserProductController extends BaseController
{
    public function index(Request $request)
    {
        $products = Product::getDetails(['product_status'=>1,'product_trash'=>0]);
        $variants = ProductVariant::where('product_variant_status',1)->get();
        $attris = AttributeVariation::getDetails(['attribute_variation_trash'=>0]);
        foreach($attris as $attri)
        {
            $att_var[$attri->attribute_variation_id][$attri->attribute_name] = $attri->attribute_variation_value;
        }
        foreach($variants as $key => $variant)
        {
            $var[$variant->product_variant_product][] = $variant;
        }
        foreach($products as $key => $product)
        {
            $pro[$key]['product_id'] = $product->product_id;
            $pro[$key]['product_image'] = asset(config('constants.admin_path').'uploads/product/'.$product->product_image);
            $pro[$key]['product_brand'] = $product->brand_name;
            $pro[$key]['product_category'] = $product->category_name;
            $pro[$key]['product_vendor'] = $product->vendor_name;
            $pro[$key]['product_sku'] = $product->product_sku;
            $pro[$key]['product_warranty'] = $product->product_warranty;
            $pro[$key]['product_price'] = $product->product_price;
            $pro[$key]['product_offer_price'] = $product->product_offer_price;
            $pro[$key]['product_description'] = $product->product_description;
            if(isset($var[$product->product_id]))
            {
                foreach($var[$product->product_id] as $vkey =>$variant)
                {
                    $attributes = json_decode($variant->product_variant_attribute,true);
                    $pro[$key]['variants'][$vkey]['product_variant_id'] = $variant->product_variant_id;
                    $pro[$key]['variants'][$vkey]['product_variant_name'] = $variant->product_variant_name;
                    $pro[$key]['variants'][$vkey]['product_variant_stock'] = $variant->product_variant_stock;
                    $pro[$key]['variants'][$vkey]['product_variant_price'] = $variant->product_variant_price;
                    $pro[$key]['variants'][$vkey]['product_variant_offer_price'] = $variant->product_variant_offer_price;
                    $pro[$key]['variants'][$vkey]['product_variant_image'] = asset(config('constants.admin_path').'uploads/product/'.$variant->product_variant_image);
                    foreach($attributes as $attribute)
                    {
                        foreach($att_var[$attribute] as $name => $value)
                        {
                            $pro[$key]['variants'][$vkey]['product_variant_attributes'][$name] = $value;
                        }

                    }
                }
            }
            else
            {
                $pro[$key]['variants'] = [];
            }
        }
        $result['products'] = $pro;
        return $this->sendResponse($result, 'Product List Fetched Successfully.');
    }

    public function product_detail(Request $request)
    {
        if($request->has('product_id'))
        {
            $product_id = $request->product_id;
            $product = Product::getDetails(['product_status'=>1,'product_trash'=>0,'product_id'=>$product_id])->first();
            $attris = AttributeVariation::getDetails(['attribute_variation_trash'=>0]);
            foreach($attris as $attri)
            {
                $att_var[$attri->attribute_variation_id][$attri->attribute_name] = $attri->attribute_variation_value;
            }
            if(isset($product))
            {
                $variants = ProductVariant::where(['product_variant_status'=>1,'product_variant_status'=>$product_id])->get();

                $pro['product_id']          = $product->product_id;
                $pro['product_image']       = asset(config('constants.admin_path').'uploads/product/'.$product->product_image);
                $pro['product_brand']       = $product->brand_name;
                $pro['product_category']    = $product->category_name;
                $pro['product_vendor']      = $product->vendor_name;
                $pro['product_sku']         = $product->product_sku;
                $pro['product_warranty']    = $product->product_warranty;
                $pro['product_price']       = $product->product_price;
                $pro['product_offer_price'] = $product->product_offer_price;
                $pro['product_description'] = $product->product_description;
                if($variants->count() > 0)
                {
                    foreach($variants as $vkey =>$variant)
                    {
                        $attributes = json_decode($variant->product_variant_attribute,true);
                        $pro['variants'][$vkey]['product_variant_id'] = $variant->product_variant_id;
                        $pro['variants'][$vkey]['product_variant_name'] = $variant->product_variant_name;
                        $pro['variants'][$vkey]['product_variant_stock'] = $variant->product_variant_stock;
                        $pro['variants'][$vkey]['product_variant_price'] = $variant->product_variant_price;
                        $pro['variants'][$vkey]['product_variant_offer_price'] = $variant->product_variant_offer_price;
                        $pro['variants'][$vkey]['product_variant_image'] = asset(config('constants.admin_path').'uploads/product/'.$variant->product_variant_image);
                        foreach($attributes as $attribute)
                        {
                            foreach($att_var[$attribute] as $name => $value)
                            {
                                $pro['variants'][$vkey]['product_variant_attributes'][$name] = $value;
                            }

                        }
                    }
                }
                else
                {
                    $pro['variants'] = [];
                }

                $result['product'] = $pro;
                $message = 'Product Detail Fetched Successfully.';

                return $this->sendResponse($result, $message);
            }
            else
            {
                return $this->sendError('No product Found', []);
            }
        }
        else
        {
            return $this->sendError('Please provide product Id', []);
        }




    }
}
