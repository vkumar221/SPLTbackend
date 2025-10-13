<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    protected $table = 'user_plans';

    protected $primaryKey = 'user_plan_id';

    public $timestamps = false;

    protected $fillable = ['user_plan_user','user_plan','user_plan_expiry','user_plan_status','user_plan_added_on','user_plan_added_by','user_plan_updated_on','user_plan_updated_by'];

    public static function getDetails($where)
    {
        $workout = new UserPlan;

        return $workout->select('*')
                        ->join('users','users.user_id','user_plans.user_plan_user')
                        ->where($where)
                        ->orderby('user_plan_id','desc')
                        ->get();
    }

}
