<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $primaryKey = 'appointment_id';

    public $timestamps = false;

    protected $fillable = ['appointment_user','appointment_date','appointment_time','appointment_status','appointment_added_by','appointment_added_on','appointment_updated_by','appointment_updated_on'];

    public static function getDetails($where)
    {
        $appointment = new Appointment;

        return $appointment->select('*')
                        ->join('users','users.id','appointments.appointment_user')
                        ->where($where)
                        ->orderby('appointment_id','desc')
                        ->get();
    }

    public static function getTrainerDetails($where)
    {
        $appointment = new Appointment;

        return $appointment->select('*')
                        ->join('users','users.id','appointments.appointment_added_by')
                        ->where($where)
                        ->orderby('appointment_id','desc')
                        ->get();
    }

}
