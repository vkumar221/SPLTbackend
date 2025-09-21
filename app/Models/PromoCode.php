<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table = 'promo_codes';

    protected $primaryKey = 'promo_code_id';

    public $timestamps = false;

    protected $fillable = ['promo_code_name','promo_code_type','promo_code_value','promo_code_max_order_value','promo_code_min_order_value','promo_code_from','promo_code_to','promo_code_usage','promo_code_max_users','promo_code_image','promo_code_status','promo_code_added_by','promo_code_added_on','promo_code_updated_by','promo_code_updated_on'];

}
