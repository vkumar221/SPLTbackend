<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutPlanExercise extends Model
{
    protected $table = 'workout_plan_exercises';

    protected $primaryKey = 'workout_plan_exercise_id';

    public $timestamps = false;

    protected $fillable = ['workout_plan_plan','workout_plan_exercise','created_at','updated_at'];

    public static function getDetails($where)
    {
        $workout = new WorkoutPlanExercise;

        return $workout->select('*')
                        ->join('workout_plans','workout_plans.workout_plan_id','workout_plan_exercises.workout_plan_plan')
                        ->join('workouts','workouts.workout_id','workout_plan_exercises.workout_plan_exercise')
                        ->join('muscle_groups','muscle_groups.muscle_group_id','workouts.workout_muscle_group')
                        ->where($where)
                        ->orderby('workout_plan_exercise_id','desc')
                        ->get();
    }

}
