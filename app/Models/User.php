<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fname','lname','uname','type','title','uname','email','password','vpassword','image','gender','age','dob','weight','height','cover_image','facebook','instagram','twitter','tiktok','youtube','bio','plan','phone','role','status','trash','added_by','added_on','updated_by','updated_on'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getClientTrainer($where)
    {
        $user = new User;

        return $user->select('*')
                        ->join('trainer_clients','trainer_clients.trainer_client','users.id')
                        ->where($where)
                        ->orderby('trainer_client_id','desc')
                        ->get();
    }
}
