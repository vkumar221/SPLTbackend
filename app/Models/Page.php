<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $primaryKey = 'page_id';

    public $timestamps = false;

    protected $fillable = ['page_title','page_content','page_status','page_added_on','page_added_by','page_updated_on','page_updated_by'];

}
