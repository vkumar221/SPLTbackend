<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseType extends Model
{
    protected $table = 'exercise_types';

    protected $primaryKey = 'exercise_type_id';

    public $timestamps = false;

    protected $fillable = ['exercise_type_name','exercise_type_status','exercise_type_added_by','exercise_type_added_on','exercise_type_updated_by','exercise_type_updated_on'];

}
