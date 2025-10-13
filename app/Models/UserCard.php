<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    protected $table = 'user_cards';

    protected $primaryKey = 'user_card_id';

    public $timestamps = false;

    protected $fillable = ['user_card_user','user_card_name','user_card_number','user_card_expiry','user_card_cvc','user_card_status','user_card_added_on','user_card_added_by','user_card_updated_on','user_card_updated_by'];

    public static function getDetails($where)
    {
        $card = new UserCard;

        return $card->select('*')
                        ->join('users','users.user_id','user_cards.user_card_user')
                        ->where($where)
                        ->orderby('user_card_id','desc')
                        ->get();
    }

}
