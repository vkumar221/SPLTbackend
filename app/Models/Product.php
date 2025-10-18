<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public $timestamps = false;

    protected $fillable = ['product_name','product_brand','product_category','product_slug','product_vendor','product_country','product_tags','product_sku','product_image','product_status','product_warranty','product_stock','product_price','product_offer_price','product_description','product_added_by','product_added_on','product_updated_by','product_updated_on'];

    public static function getDetails($where)
    {
        $product = new Product;

        return $product->select('*')
                        ->join('categories','categories.category_id','products.product_category')
                        ->join('brands','brands.brand_id','products.product_brand')
                        ->join('countries','countries.country_id','products.product_country')
                        ->join('users','users.id','products.product_vendor')
                        ->where($where)
                        ->orderby('product_id','desc')
                        ->get();
    }

    public static function getFilter($where,$order,$order_by,$search,$wherein)
    {
        $product = new Product;

        if($search != '' && $wherein != '')
        {
            return $product->select('*')
                        ->join('categories','categories.category_id','products.product_category')
                        ->where($where)
                        ->whereIn('categories.category_slug',$wherein)
                        ->where('product_name','LIKE','%' . $search . '%')
                        ->orderby($order,$order_by)
                        ->paginate(24);
        }
        elseif($search == '' && $wherein != '')
        {
            return $product->select('*')
            ->join('categories','categories.category_id','products.product_category')
            ->where($where)
            ->whereIn('categories.category_slug',$wherein)
            ->orderby($order,$order_by)
            ->paginate(24);
        }
        elseif($search != '' && $wherein == '')
        {
            return $product->select('*')
            ->join('categories','categories.category_id','products.product_category')
            ->where($where)
            ->where('product_name','LIKE','%' . $search . '%')
            ->orderby($order,$order_by)
            ->paginate(24);
        }
        else
        {
            return $product->select('*')
            ->join('categories','categories.category_id','products.product_category')
            ->where($where)
            ->orderby($order,$order_by)
            ->paginate(24);
        }
    }

}
