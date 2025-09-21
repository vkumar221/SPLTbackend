<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $primaryKey = 'admin_id';

    public $timestamps = false;

    protected $fillable = ['admin_name','admin_image','admin_mobile','admin_email','admin_password','admin_vpassword','admin_role','admin_address','admin_added_on','admin_added_by','admin_updated_on','admin_updated_by','admin_status'];

    protected $hidden = ['admin_password'];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }



}
