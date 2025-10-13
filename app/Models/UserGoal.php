<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGoal extends Model
{
    protected $table = 'user_goals';

    protected $primaryKey = 'user_goal_id';

    public $timestamps = false;

    protected $fillable = ['user_goal_user','user_goal_name','user_goal_type','user_goal_weight','user_goal_weight_target','user_goal_weight_duration','user_goal_fat','user_goal_fat_target','user_goal_fat_duration','user_goal_muscle','user_goal_muscle_current','user_goal_muscle_target','user_goal_muscle_duration','user_goal_status','user_goal_added_on','user_goal_added_by','user_goal_updated_on','user_goal_updated_by'];

    public static function getDetails($where)
    {
        $workout = new UserGoal;

        return $workout->select('*')
                        ->join('users','users.user_id','user_goals.user_goal_user')
                        ->where($where)
                        ->orderby('user_goal_id','desc')
                        ->get();
    }

}
