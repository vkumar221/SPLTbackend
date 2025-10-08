<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerCertificate extends Model
{
    protected $table = 'trainer_certificates';

    protected $primaryKey = 'certificate_id';

    public $timestamps = false;

    protected $fillable = ['certificate_order','certificate_item','certificate_rating','certificate_comment','certificate_status','certificate_added_on','certificate_added_by','certificate_updated_on','certificate_updated_by'];

    public static function getDetails($where)
    {
        $certificate = new TrainerCertificate;

        return $certificate->select('*')
                        ->join('trainers','trainers.trainer_id','trainer_certificates.certificate_added_by')
                        ->where($where)
                        ->orderby('certificate_id','desc')
                        ->get();
    }

}
