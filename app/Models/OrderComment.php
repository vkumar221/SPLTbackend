<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderComment extends Model
{
    protected $table = 'order_comments';

    protected $primaryKey = 'order_comment_id';

    public $timestamps = false;

    protected $fillable = ['order_comment_order','order_comment_item','order_comment_order_status','order_comment_pay_status','order_comment_nofity','order_comment_append','order_comment_text','order_comment_status','order_comment_added_on','order_comment_added_by','order_comment_updated_on','order_comment_updated_by'];

    public static function getDetails($where)
    {
        $order_comment = new OrderComment;

        return $order_comment->select('*')
                        ->join('orders','orders.order_id','order_comments.order_comment_order')
                        ->join('order_items','order_items.order_item_id','order_comments.order_comment_item')
                        ->join('products','products.product_id','order_items.order_item_product')
                        ->leftJoin('product_variants','product_variants.product_variant_id','order_items.order_item_variant')
                        ->join('vendors','vendors.vendor_id','products.product_vendor')
                        ->where($where)
                        ->orderby('order_comment_id','desc')
                        ->get();
    }

}
