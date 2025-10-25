<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuestion extends Model
{
    protected $table = 'user_questions';

    protected $primaryKey = 'user_question_id';

    public $timestamps = false;

    protected $fillable = ['user_question','user_question_answer','user_question_status','user_question_added_on','user_question_added_by','user_question_updated_on','user_question_updated_by'];

}
