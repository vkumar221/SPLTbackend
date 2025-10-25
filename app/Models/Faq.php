<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';

    protected $primaryKey = 'faq_id';

    public $timestamps = false;

    protected $fillable = ['faq_question','faq_answer','faq_status','faq_added_on','faq_added_by','faq_updated_on','faq_updated_by'];

}
