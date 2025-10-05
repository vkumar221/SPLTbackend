<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_reviews';

    protected $primaryKey = 'product_review_id';

    public $timestamps = false;

    protected $fillable = ['product_review_order','product_review_item','product_review_rating','product_review_comment','product_review_status','product_review_added_on','product_review_added_by','product_review_updated_on','product_review_updated_by'];

    public static function getDetails($where)
    {
        $product_review = new ProductReview;

        return $product_review->select('*')
                        ->join('orders','orders.order_id','product_reviews.product_review_order')
                        ->join('order_items','order_items.order_item_id','product_reviews.product_review_item')
                        ->join('products','products.product_id','order_items.order_item_product')
                        ->leftJoin('product_variants','product_variants.product_variant_id','order_items.order_item_variant')
                        ->join('vendors','vendors.vendor_id','products.product_vendor')
                        ->where($where)
                        ->orderby('product_review_id','desc')
                        ->get();
    }

}
