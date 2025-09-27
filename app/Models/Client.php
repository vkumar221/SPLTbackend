<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    protected $table = 'clients';

    protected $primaryKey = 'client_id';

    public $timestamps = false;

    protected $fillable = ['client_name','client_phone','client_email','client_password','client_vpassword','client_status','client_plan','client_program','client_added_by','client_added_on','client_updated_by','client_updated_on'];

    protected $hidden = ['client_password'];

    public function getAuthPassword()
    {
        return $this->client_password;
    }


}
