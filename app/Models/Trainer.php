<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainer extends Authenticatable
{
    protected $table = 'trainers';

    protected $primaryKey = 'trainer_id';

    public $timestamps = false;

    protected $fillable = ['trainer_name','trainer_phone','trainer_type','trainer_email','trainer_password','trainer_vpassword','trainer_status','trainer_plan','trainer_facebook','trainer_instagram','trainer_tiktok','trainer_x','trainer_youtube','trainer_added_by','trainer_added_on','trainer_updated_by','trainer_updated_on'];

    protected $hidden = ['trainer_password'];

    public function getAuthPassword()
    {
        return $this->trainer_password;
    }


}
