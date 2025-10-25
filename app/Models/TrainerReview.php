<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerReview extends Model
{
    protected $table = 'trainer_reviews';

    protected $primaryKey = 'review_id';

    public $timestamps = false;

    protected $fillable = ['review_user','review_rating','review_comment','review_status','review_added_on','review_added_by','review_updated_on','review_updated_by'];

    public static function getDetails($where)
    {
        $trainer_review = new TrainerReview;

        return $trainer_review->select('*')
                        ->join('users','users.id','trainer_reviews.review_added_by')
                        ->where($where)
                        ->orderby('review_id','desc')
                        ->get();
    }

}
