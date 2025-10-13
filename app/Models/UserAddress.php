<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresss';

    protected $primaryKey = 'user_address_id';

    public $timestamps = false;

    protected $fillable = ['user_address_user','user_address_name','user_address_line1','user_address_line2','user_address_city','user_address_state','user_address_country','user_address_zipcode','user_address_status','user_address_added_on','user_address_added_by','user_address_updated_on','user_address_updated_by'];

    public static function getDetails($where)
    {
        $address = new UserAddress;

        return $address->select('*')
                        ->join('users','users.user_id','user_addresss.user_address_user')
                        ->where($where)
                        ->orderby('user_address_id','desc')
                        ->get();
    }

}
