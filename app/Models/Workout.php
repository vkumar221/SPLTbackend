<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'workouts';

    protected $primaryKey = 'workout_id';

    public $timestamps = false;

    protected $fillable = ['workout_name','workout_type','workout_equipment','workout_muscle_group','workout_other_muscle','workout_category','workout_instruction','workout_image','workout_vimeo','workout_youtube','workout_status','workout_trash','workout_added_role','workout_added_by','workout_added_on','workout_updated_by','workout_updated_on'];

    public static function getDetails($where)
    {
        $workout = new Workout;

        return $workout->select('*')
                        ->join('workout_categories','workout_categories.workout_category_id','workouts.workout_category')
                        ->join('equipments','equipments.equipment_id','workouts.workout_equipment')
                        ->join('muscle_groups','muscle_groups.muscle_group_id','workouts.workout_muscle_group')
                        ->join('exercise_types','exercise_types.exercise_type_id','workouts.workout_type')
                        ->where($where)
                        ->orderby('workout_id','desc')
                        ->get();
    }

    public static function getDetailWherein($wherein)
    {
        $workout = new Workout;

        return $workout->select('*')
                        ->join('workout_categories','workout_categories.workout_category_id','workouts.workout_category')
                        ->join('equipments','equipments.equipment_id','workouts.workout_equipment')
                        ->join('muscle_groups','muscle_groups.muscle_group_id','workouts.workout_muscle_group')
                        ->join('exercise_types','exercise_types.exercise_type_id','workouts.workout_type')
                        ->whereIn('workout_id',$wherein)
                        ->orderby('workout_id','desc')
                        ->get();
    }

    public static function getDetailFilter($where,$wherein)
    {
        $workout = new Workout;
        if($where != '' && $wherein != '')
        {
            return $workout->select('*')
                        ->join('workout_categories','workout_categories.workout_category_id','workouts.workout_category')
                        ->join('equipments','equipments.equipment_id','workouts.workout_equipment')
                        ->join('muscle_groups','muscle_groups.muscle_group_id','workouts.workout_muscle_group')
                        ->join('exercise_types','exercise_types.exercise_type_id','workouts.workout_type')
                        ->where($where)
                        ->whereNotIn('workout_id',$wherein)
                        ->orderby('workout_id','desc')
                        ->get();
        }
        if($where != '' && $wherein == '')
        {
            return $workout->select('*')
                        ->join('workout_categories','workout_categories.workout_category_id','workouts.workout_category')
                        ->join('equipments','equipments.equipment_id','workouts.workout_equipment')
                        ->join('muscle_groups','muscle_groups.muscle_group_id','workouts.workout_muscle_group')
                        ->join('exercise_types','exercise_types.exercise_type_id','workouts.workout_type')
                        ->where($where)
                        ->orderby('workout_id','desc')
                        ->get();
        }
    }

}
