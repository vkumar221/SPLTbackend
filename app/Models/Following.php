<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $table = 'followings';

    protected $primaryKey = 'following_id';

    public $timestamps = false;

    protected $fillable = ['following_follower','following_status','following_added_by','following_added_on','following_updated_by','following_updated_on'];

    public static function getDetails($where)
    {
        $following = new Following;

        return $following->select('*')
                        ->join('users','users.id','followings.following_follower')
                        ->where($where)
                        ->orderby('following_id','desc')
                        ->get();
    }

}
