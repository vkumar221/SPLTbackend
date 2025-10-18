<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';

    protected $primaryKey = 'newsletter_id';

    public $timestamps = false;

    protected $fillable = ['newsletter_title','newsletter_date','newsletter_image','newsletter_description','newsletter_category','newsletter_product','newsletter_audience','newsletter_status','newsletter_trash','newsletter_added_role','newsletter_added_by','newsletter_added_on','newsletter_updated_by','newsletter_updated_on'];

    public static function getDetails($where)
    {
        $newsletter = new Newsletter;

        return $newsletter->select('*')
                        ->join('categories','categories.category_id','newsletters.newsletter_category')
                        ->join('products','products.product_id','newsletters.newsletter_product')
                        ->where($where)
                        ->orderby('newsletter_id','desc')
                        ->get();
    }

}
