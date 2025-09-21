<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    protected $table = 'vendors';

    protected $primaryKey = 'vendor_id';

    public $timestamps = false;

    protected $fillable = ['vendor_name','vendor_phone','vendor_type','vendor_email','vendor_password','vendor_vpassword','vendor_status','vendor_added_by','vendor_added_on','vendor_updated_by','vendor_updated_on'];

    protected $hidden = ['vendor_password'];

    public function getAuthPassword()
    {
        return $this->vendor_password;
    }


}
