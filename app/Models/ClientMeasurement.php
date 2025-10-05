<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientMeasurement extends Model
{
    protected $table = 'client_measurements';

    protected $primaryKey = 'client_measurement_id';

    public $timestamps = false;

    protected $fillable = ['client_measurement_client','client_measurement_part','client_measurement','client_measurement_date','client_measurement_status','client_measurement_added_on','client_measurement_updated_by','client_measurement_updated_on'];

}
