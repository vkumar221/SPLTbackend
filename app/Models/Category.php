<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    public $timestamps = false;

    protected $fillable = ['category_name','category_slug','category_image','category_cover_image','category_feature_image','category_description','category_status','category_added_by','category_added_on','category_updated_by','category_updated_on'];

}
