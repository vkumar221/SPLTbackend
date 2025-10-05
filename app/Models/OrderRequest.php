<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    protected $table = 'order_requests';

    protected $primaryKey = 'order_request_id';

    public $timestamps = false;

    protected $fillable = ['order_request_order','order_request_item','order_request_comment','order_request_reply','order_request_status','order_request_added_on','order_request_added_by','order_request_updated_on','order_request_updated_by'];

    public static function getDetails($where)
    {
        $order_request = new OrderRequest;

        return $order_request->select('*')
                        ->join('orders','orders.order_id','order_requests.order_request_order')
                        ->join('order_items','order_items.order_item_id','order_requests.order_request_item')
                        ->join('products','products.product_id','order_items.order_item_product')
                        ->leftJoin('product_variants','product_variants.product_variant_id','order_items.order_item_variant')
                        ->join('vendors','vendors.vendor_id','products.product_vendor')
                        ->where($where)
                        ->orderby('order_request_id','desc')
                        ->get();
    }

}
