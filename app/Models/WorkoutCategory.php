<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutCategory extends Model
{
    protected $table = 'workout_categories';

    protected $primaryKey = 'workout_category_id';

    public $timestamps = false;

    protected $fillable = ['workout_category_name','workout_category_slug','workout_category_image','workout_category_cover_image','workout_category_feature_image','workout_category_description','workout_category_status','workout_category_added_by','workout_category_added_on','workout_category_updated_by','workout_category_updated_on'];

}
