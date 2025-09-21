<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $primaryKey = 'product_variant_id';

    public $timestamps = false;

    protected $fillable = ['product_variant_product','product_variant_attribute','product_variant_name','product_variant_price','product_variant_offer_price','product_variant_stock','product_variant_image','product_variant_status','product_variant_added_by','product_variant_added_on','product_variant_updated_by','product_variant_updated_on'];

}
