<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    protected $table = 'workout_plans';

    protected $primaryKey = 'workout_plan_id';

    public $timestamps = false;

    protected $fillable = ['workout_plan_name','workout_plan_category','workout_plan_duration','workout_plan_goal','workout_plan_days','workout_plan_note','workout_plan_status','workout_plan_added_by','workout_plan_added_on','workout_plan_updated_by','workout_plan_updated_on'];

    public static function getDetails($where)
    {
        $workout_plan = new WorkoutPlan;

        return $workout_plan->select('*')
                        ->join('workout_categories','workout_categories.workout_category_id','workout_plans.workout_plan_category')
                        ->where($where)
                        ->orderby('workout_plan_id','desc')
                        ->get();
    }

    public static function getPlanTrainer($where)
    {
        $workout_plan = new WorkoutPlan;

        return $workout_plan->select('*')
                        ->join('trainer_workout_plans','trainer_workout_plans.trainer_workout_plan','workout_plans.workout_plan_id')
                        ->join('workout_categories','workout_categories.workout_category_id','workout_plans.workout_plan_category')
                        ->where($where)
                        ->orderby('trainer_workout_plan_id','desc')
                        ->get();
    }

}
