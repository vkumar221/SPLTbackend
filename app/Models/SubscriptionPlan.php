<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $primaryKey = 'subscription_plan_id';

    public $timestamps = false;

    protected $fillable = ['subscription_plan_title','subscription_plan_price','subscription_plan_discount','subscription_plan_image','subscription_plan_description','subscription_plan_popular','subscription_plan_role','subscription_plan_status','subscription_plan_added_by','subscription_plan_added_on','subscription_plan_updated_by','subscription_plan_updated_on'];

}
