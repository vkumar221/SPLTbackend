<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeVariation extends Model
{
    protected $table = 'attribute_variations';

    protected $primaryKey = 'attribute_variation_id';

    public $timestamps = false;

    protected $fillable = ['attribute_variation_name','attribute_variation_attribute','attribute_variation_value','attribute_variation_status','attribute_variation_added_by','attribute_variation_added_on','attribute_variation_updated_by','attribute_variation_updated_on'];

    public static function getDetails($where)
    {
        $attribute = new AttributeVariation;

        return $attribute->select('*')
                        ->join('attributes','attributes.attribute_id','attribute_variations.attribute_variation_attribute')
                        ->join('categories','categories.category_id','attributes.attribute_category')
                        ->where($where)
                        ->get();
    }

}
