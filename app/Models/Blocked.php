<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blocked extends Model
{
    protected $table = 'blocked';

    protected $primaryKey = 'blocked_id';

    public $timestamps = false;

    protected $fillable = ['blocked_user','blocked_status','blocked_added_by','blocked_added_on','blocked_updated_by','blocked_updated_on'];

    public static function getDetails($where)
    {
        $blocked = new Blocked;

        return $blocked->select('*')
                        ->join('users','users.id','blocked.blocked_user')
                        ->where($where)
                        ->orderby('blocked_id','desc')
                        ->get();
    }

}
