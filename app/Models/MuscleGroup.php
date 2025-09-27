<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuscleGroup extends Model
{
    protected $table = 'muscle_groups';

    protected $primaryKey = 'muscle_group_id';

    public $timestamps = false;

    protected $fillable = ['muscle_group_name','muscle_group_status','muscle_group_added_by','muscle_group_added_on','muscle_group_updated_by','muscle_group_updated_on'];

}
