<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';

    protected $primaryKey = 'attribute_id';

    public $timestamps = false;

    protected $fillable = ['attribute_name','attribute_type','attribute_category','attribute_status','attribute_added_by','attribute_added_on','attribute_updated_by','attribute_updated_on'];

    public static function getDetails($where)
    {
        $attribute = new Attribute;

        return $attribute->select('*')
                        ->join('categories','categories.category_id','attributes.attribute_category')
                        ->where($where)
                        ->get();
    }

}
