<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    public $timestamps = false;

    protected $fillable = ['order_refid','order_name','order_company','order_email','order_price','order_total','order_cod','order_coupon','order_coupon_code','order_discount','order_discount_per','order_paid','order_phone','order_address','order_address2','order_country','order_city','order_state','order_zip','order_ip','order_track_link','order_payment','order_status','order_notes','order_added_by','order_added_on','order_updated_by','order_updated_on'];

    public static function getDetails($where)
    {
        $order = new Order;

        return $order->select('*')
                        ->join('users','users.id','orders.order_added_by')
                        ->where($where)
                        ->orderby('order_id','desc')
                        ->get();
    }

}
