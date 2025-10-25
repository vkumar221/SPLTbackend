<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $primaryKey = 'setting_id';

    public $timestamps = false;

    protected $fillable = ['setting_name','setting_email','setting_phone','setting_address','setting_logo','setting_logo_light','setting_favicon','setting_facebook','setting_twitter','setting_instagram','setting_youtube','setting_updated_on','setting_updated_by'];

}
