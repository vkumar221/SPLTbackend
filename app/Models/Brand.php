<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $primaryKey = 'brand_id';

    public $timestamps = false;

    protected $fillable = ['brand_name','brand_slug','brand_image','brand_cover_image','brand_category','brand_description','brand_status','brand_added_by','brand_added_on','brand_updated_by','brand_updated_on'];

}
