<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $primaryKey = 'inventory_id';

    public $timestamps = false;

    protected $fillable = ['inventory_product','inventory_variant','inventory_open_stock','inventory_close_stock','inventory_added_on','inventory_added_by','inventory_updated_on','inventory_updated_by'];

    public static function getDetails($where)
    {
        $inventory = new Inventory;

        return $inventory->select('*')
                           ->leftjoin('products','products.product_id','inventory.inventory_product')
                           ->leftjoin('categories','categories.category_id','products.product_category')
                           ->leftjoin('product_variants','product_variants.product_variant_id','inventory.inventory_variant')
                           ->leftjoin('vendors','vendors.vendor_id','products.product_vendor')
                           ->where($where)
                           ->orderby('inventory_id','desc')
                           ->get();
    }



}
