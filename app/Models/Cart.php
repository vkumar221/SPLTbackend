<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $primaryKey = 'cart_id';

    public $timestamps = false;

    protected $fillable = ['cart_product','cart_name','cart_offer_price','cart_price','cart_quantity','cart_variant','cart_user','cart_added_by','cart_added_on','cart_updated_by','cart_updated_on'];

    public static function getDetails($where)
    {
        $cart = new Cart;

        return $cart->select('*')
                        ->join('products','products.product_id','carts.cart_product')
                        ->leftJoin('product_variants','product_variants.product_variant_id','carts.cart_variant')
                        ->join('categories','categories.category_id','products.product_category')
                        ->join('brands','brands.brand_id','products.product_brand')
                        ->join('countries','countries.country_id','products.product_country')
                        ->join('vendors','vendors.vendor_id','products.product_vendor')
                        ->where($where)
                        ->orderby('product_id','desc')
                        ->get();
    }

}
