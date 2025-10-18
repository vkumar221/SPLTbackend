<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $primaryKey = 'order_item_id';

    public $timestamps = false;

    protected $fillable = ['order_item_order','order_item_product','order_item_quantity','order_item_variant','order_item_price','order_item_status'];

    public static function getDetails($where)
    {
        $order_item = new OrderItem;

        return $order_item->select('*')
                        ->join('orders','orders.order_id','order_items.order_item_order')
                        ->join('products','products.product_id','order_items.order_item_product')
                        ->leftJoin('product_variants','product_variants.product_variant_id','order_items.order_item_variant')
                        ->join('users','users.id','products.product_vendor')
                        ->where($where)
                        ->orderby('order_item_id','desc')
                        ->get();
    }

    public static function getOrder($where)
    {
        $order_item = new OrderItem;

        return $order_item->select('*')
                        ->join('orders','orders.order_id','order_items.order_item_order')
                        ->join('products','products.product_id','order_items.order_item_product')
                        ->leftJoin('product_variants','product_variants.product_variant_id','order_items.order_item_variant')
                        ->join('users','users.id','products.product_vendor')
                        ->where($where)
                        ->orderby('order_item_id','desc')
                        ->groupBy('order_id')
                        ->get();
    }

}
