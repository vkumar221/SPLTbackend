<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Auth;
use Hash;
use Validator;
use Helpers;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCard;
use App\Models\Following;

class UserProfileController extends BaseController
{
    public function index(Request $request)
    {
        $result['fname'] = Auth::user()->fname;
        $result['lname'] = Auth::user()->lname;
        $result['email '] = Auth::user()->email;
        $result['uname'] = Auth::user()->uname;
        $result['image'] = (Auth::user()->image != NULL) ? url(asset(config('constants.user_path').'uploads/profile/'.Auth::user()->image)) : url(asset(config('constants.user_path').'uploads/no-image.png'));
        $result['role'] = (Auth::user()->role == 1) ? 'Client' : 'Trainer';

        return $this->sendResponse($result, 'User Profile Informations fetched successfully.');

    }

    public function update_profile(Request $request)
    {
        $rules = [
                    'fname' => 'required',
                    'lname' => 'required',
                    'email' => 'required|email',
                    'uname' => 'required',
                    'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                ];

        $messages = [
                     'fname.required' => 'Please Enter First Name',
                     'lname.required' => 'Please Enter Last Name',
                     'email.required' => 'Please Enter Email Address',
                     'email.email' => 'Please Enter Valid Email Address',
                     'uname.required' => 'Please Enter username',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $where_email['email'] = $request->email;
            $check_email = User::where($where_email)->where('id','!=',Auth::user()->id)->count();

            if($check_email > 0)
            {
                return $this->sendError([], ['error'=>'Email ID already in use']);
            }

            $where_uname['uname'] = $request->uname;
            $check_uname = User::where($where_uname)->where('id','!=',Auth::user()->id)->count();

            if($check_email > 0)
            {
                return $this->sendError([], ['error'=>'Email ID already in use']);
            }

            if($check_uname > 0)
            {
                return $this->sendError([], ['error'=>'Username already in use']);
            }

            $upd['fname']      = $request->fname;
            $upd['lname']      = $request->lname;
            $upd['email']      = $request->email;
            $upd['uname']      = $request->uname;
            $upd['gender']     = $request->gender;
            $upd['age']        = $request->age;
            $upd['dob']        = $request->dob;
            $upd['weight']     = $request->weight;
            $upd['height']     = $request->height;
            $upd['updated_at'] = date('Y-m-d H:i:s');

            if($request->hasFile('image'))
            {
                $image = $request->image->store('assets/user/uploads/profile');

                $image = explode('/',$image);
                $image = end($image);
                $upd['image'] = $image;
            }

            $user = User::where('id',Auth::user()->id)->update($upd);

            return $this->sendResponse([], 'User Details updated Successfully.');
        }
    }

    public function trainer_profile(Request $request)
    {
        $result['fname'] = Auth::user()->fname;
        $result['lname'] = Auth::user()->lname;
        $result['title'] = Auth::user()->title;
        $result['email '] = Auth::user()->email;
        $result['uname'] = Auth::user()->uname;
        $result['gender'] = Auth::user()->gender;
        $result['image'] = (Auth::user()->image != NULL) ? url(asset(config('constants.user_path').'uploads/profile/'.Auth::user()->image)) : url(asset(config('constants.user_path').'uploads/no-image.png'));
        $result['role'] = (Auth::user()->role == 1) ? 'Client' : 'Trainer';
        $result['banner'] = (Auth::user()->cover_image != NULL) ? url(asset(config('constants.user_path').'uploads/profile/'.Auth::user()->cover_image)) : url(asset(config('constants.user_path').'uploads/no-image.png'));
        $result['bio'] = Auth::user()->bio;
        $result['following'] = Following::getDetails(['following_added_by'=>Auth::user()->id,'following_trash'=>0])->count();
        $result['followers'] = Following::getDetails(['following_follower'=>Auth::user()->id,'following_trash'=>0])->count();

        return $this->sendResponse($result, 'User Profile Informations fetched successfully.');

    }

    public function trainer_update_profile(Request $request)
    {
        $rules = [
                    'fname' => 'required',
                    'lname' => 'required',
                    'email' => 'required|email',
                    'uname' => 'required',
                    'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                    'banner' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                    'gender' => 'required',
                ];

        $messages = [
                     'fname.required' => 'Please Enter First Name',
                     'lname.required' => 'Please Enter Last Name',
                     'email.required' => 'Please Enter Email Address',
                     'email.email' => 'Please Enter Valid Email Address',
                     'uname.required' => 'Please Enter username',
                     'gender.required' => 'Please Enter Gender',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $where_email['email'] = $request->email;
            $check_email = User::where($where_email)->where('id','!=',Auth::user()->id)->count();

            if($check_email > 0)
            {
                return $this->sendError([], ['error'=>'Email ID already in use']);
            }

            $where_uname['uname'] = $request->uname;
            $check_uname = User::where($where_uname)->where('id','!=',Auth::user()->id)->count();

            if($check_email > 0)
            {
                return $this->sendError([], ['error'=>'Email ID already in use']);
            }

            if($check_uname > 0)
            {
                return $this->sendError([], ['error'=>'Username already in use']);
            }

            $upd['fname']      = $request->fname;
            $upd['lname']      = $request->lname;
            $upd['email']      = $request->email;
            $upd['uname']      = $request->uname;
            $upd['title']      = $request->title;
            $upd['gender']     = $request->gender;
            $upd['age']        = $request->age;
            $upd['dob']        = $request->dob;
            $upd['weight']     = $request->weight;
            $upd['height']     = $request->height;
            $upd['bio']        = $request->bio;
            $upd['instagram']  = $request->instagram;
            $upd['twitter']    = $request->twitter;
            $upd['facebook']   = $request->facebook;
            $upd['youtube']    = $request->youtube;
            $upd['tiktok']     = $request->tiktok;
            $upd['updated_at'] = date('Y-m-d H:i:s');

            if($request->hasFile('image'))
            {
                $image = $request->image->store('assets/user/uploads/profile');

                $image = explode('/',$image);
                $image = end($image);
                $upd['image'] = $image;
            }

            if($request->hasFile('banner'))
            {
                $image = $request->banner->store('assets/user/uploads/profile');

                $banner = explode('/',$image);
                $banner = end($banner);
                $upd['cover_image'] = $banner;
            }

            $user = User::where('id',Auth::user()->id)->update($upd);

            return $this->sendResponse([], 'User Details updated Successfully.');
        }
    }

    public function social_media(Request $request)
    {
        $result['email '] = Auth::user()->email;
        $result['facebook'] = Auth::user()->facebook;
        $result['instagram'] = Auth::user()->instagram;
        $result['twitter'] = Auth::user()->twitter;
        $result['tiktok'] = Auth::user()->tiktok;
        $result['youtube'] = Auth::user()->youtube;

        return $this->sendResponse($result, 'User Social Media fetched successfully.');

    }

    public function change_mobile(Request $request)
    {
        $mobile = $request->new_mobile;

        $where_mobile['mobile'] = $request->new_mobile;

        $check_mobile = User::where($where_mobile)->where('id','!=',Auth::user()->id)->count();

        if($check_mobile > 0)
        {
            return $this->sendError('Mobile Number Already in use', []);
        }
        else
        {
            $new_otp = random_int(100000, 999999);

            $upd['otp'] = $new_otp;
            $upd['mobile_verify_within'] = strtotime(date('Y-m-d H:i:s')) + 60;

            $update = User::where('id',Auth::user()->id)->update($upd);

            if($update)
            {
                $data['mobile'] = '91'.$mobile;
                $data['message'] = $new_otp.' is your verification code. For your security, do not share this code.';
                $data['api_key'] = $request->sms_settings->sms_setting_appkey;

                $status = Helper::sendMessage($data);

                $data1['auth_key'] = $request->sms_settings->sms_setting_key;
                $data1['mobile'] = $mobile;
                $data1['otp'] = $new_otp;

                $sms_status = Helper::sendSMS($data1);

                if(isset($status) && $status == true)
                {
                    $result['new_mobile'] = $mobile;

                    return $this->sendResponse([], 'OTP sent to new mobile.');
                }
                elseif(isset($sms_status) && $sms_status == true)
                {
                    $result['new_mobile'] = $mobile;

                    return $this->sendResponse([], 'OTP sent to new mobile.');
                }
                else
                {
                    return $this->sendError('OTP could not sent. Please contact Admin', []);
                }
            }
        }
    }

    public function verify_new_mobile(Request $request)
    {
        $rules = ['new_mobile' => 'required|digits:10',
                      'otp' => 'required',];

        $messages = ['new_mobile.required' => 'Please Enter Mobile Number',
                        'otp.required' => 'Please Enter OTP'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $where_mobile['mobile'] = $request->new_mobile;
        $check_mobile = User::where($where_mobile)->where('id','!=',Auth::user()->id)->count();
        $user = User::find(Auth::user()->id);
        if($check_mobile > 0)
        {
            return $this->sendError('Mobile Number Already in use', []);
        }
        else
        {
            if($user->otp == $request->otp)
            {
                $upd['mobile']   = $request->new_mobile;
                $upd['otp']   = NULL;
                $upd['mobile_verify_within'] = strtotime(date('Y-m-d H:i:s'));
                $upd['updated_at'] = date('Y-m-d H:i:s');
                $upd['updated_by'] = 0;

                $update = User::where('id',Auth::user()->id)->update($upd);

                return $this->sendResponse([], 'Mobile Number Changed Successfully.');
            }
            else
            {
                return $this->sendResponse([], 'Enter Valid OTP');
            }
        }

    }

    public function change_password(Request $request)
    {
        $rules = ['current_password' => 'required',
                      'new_password' => 'required',
                      'confirm_password' => 'required|same:new_password'];

        $messages = ['current_password.required' => 'Please Enter Current Password',
                        'new_password.required' => 'Please Enter New Password',
                        'confirm_password.required' => 'Please Enter Confirm Password'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            if(!Hash::check($request->current_password, Auth::user()->password)){
                return $this->sendError('Old Password Does not match!', []);
            }

            $upd['password']   = Hash::make($request->new_password);
            $upd['updated_at'] = date('Y-m-d H:i:s');
            $upd['updated_by'] = 0;

            $update = User::where('id',Auth::user()->id)->update($upd);

            $tokens =  Auth::user()->tokens->pluck('id');
            Token::whereIn('id', $tokens)
                ->update(['revoked'=> true]);

            RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);

            return $this->sendResponse([], 'Password Changed Successfully. Please login again with new password');
        }

    }

    public function address_list(Request $request)
    {
        $addresses = UserAddress::where('user_address_user',Auth::user()->id)->get();
        if($addresses->count() > 0)
        {
            foreach($addresses as $key=> $address)
            {
                $add[$key]['address_id'] = $address->user_address_id;
                $add[$key]['address_name'] = $address->user_address_name;
                $add[$key]['address_line1'] = $address->user_address_line1;
                $add[$key]['address_line2'] = $address->user_address_line2;
                $add[$key]['user_address_city'] = $address->user_address_city;
                $add[$key]['user_address_state'] = $address->user_address_state;
                $add[$key]['user_address_zipcode'] = $address->user_address_zipcode;
            }
            $result['addresses'] = $add;
            return $this->sendResponse($result,'Address List.');
        }
        else
        {
             return $this->sendResponse([],'No Address List.');
        }

    }

    public function add_address(Request $request)
    {
        $rules = [
                    'address_name' => 'required',
                    'address_line1' => 'required',
                    'address_city' => 'required',
                    'address_state' => 'required',
                    'address_zipcode' => 'required',
                ];

        $messages = [
                     'address_name.required' => 'Please Enter Name',
                     'address_line1.required' => 'Please Enter Address Line 1',
                     'address_city.required' => 'Please Enter City',
                     'address_state.required' => 'Please Enter State',
                     'address_zipcode.required' => 'Please Enter Zipcode',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $ins['user_address_user']        = Auth::user()->id;
            $ins['user_address_name']        = $request->address_name;
            $ins['user_address_line1']       = $request->address_line1;
            $ins['user_address_line2']       = $request->address_line2;
            $ins['user_address_city']        = $request->address_city;
            $ins['user_address_state']       = $request->address_state;
            $ins['user_address_zipcode']     = $request->address_zipcode;
            $ins['user_address_added_by']    = Auth::user()->id;
            $ins['user_address_updated_by']  = Auth::user()->id;
            $ins['user_address_added_on']    = date('Y-m-d H:i:s');
            $ins['user_address_updated_on']  = date('Y-m-d H:i:s');

            $insert = UserAddress::create($ins);

            return $this->sendResponse([], 'Address added Successfully.');
        }
    }

    public function edit_address(Request $request)
    {
        $rules = [ 'address_id' => 'required',
                    'address_name' => 'required',
                    'address_line1' => 'required',
                    'address_city' => 'required',
                    'address_state' => 'required',
                    'address_zipcode' => 'required',
                ];

        $messages = [
                    'address_id.required' => 'Please Provide Address ID',
                     'address_name.required' => 'Please Enter Name',
                     'address_line1.required' => 'Please Enter Address Line 1',
                     'address_city.required' => 'Please Enter City',
                     'address_state.email' => 'Please Enter State',
                     'address_zipcode.required' => 'Please Enter Zipcode',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $address = UserAddress::where(['user_address_user'=>Auth::user()->id,'user_address_id'=>$request->address_id])->count();
            if($address > 0)
            {
                $upd['user_address_name']        = $request->address_name;
                $upd['user_address_line1']       = $request->address_line1;
                $upd['user_address_line2']       = $request->address_line2;
                $upd['user_address_city']        = $request->address_city;
                $upd['user_address_state']       = $request->address_state;
                $upd['user_address_zipcode']     = $request->address_zipcode;
                $upd['user_address_updated_by']  = Auth::user()->id;
                $upd['user_address_updated_on']  = date('Y-m-d H:i:s');

                $update = UserAddress::where('user_address_id',$request->address_id)->update($upd);

                return $this->sendResponse([], 'Address updated Successfully.');
            }
            else
            {
                return $this->sendError([], ['error'=>'Address not Found.']);
            }
        }
    }

    public function delete_address(Request $request)
    {
        $rules = [ 'address_id' => 'required',
                ];

        $messages = [
                    'address_id.required' => 'Please Provide Address id',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $address = UserAddress::where(['user_address_user'=>Auth::user()->id,'user_address_id'=>$request->address_id])->count();
            if($address > 0)
            {
                $delete = UserAddress::where('user_address_id',$request->address_id)->delete();

                return $this->sendResponse([], 'Address Deleted Successfully.');
            }
            else
            {
                return $this->sendError([], ['error'=>'Address not Found.']);
            }
        }
    }

    public function card_list(Request $request)
    {
        $cards = UserCard::where('user_card_user',Auth::user()->id)->get();
        if($cards->count() > 0)
        {
            foreach($cards as $key=> $card)
            {
                $cad[$key]['card_id'] = $card->user_card_id;
                $cad[$key]['card_name'] = $card->user_card_name;
                $cad[$key]['card_number'] = Helpers::maskCardNumber($card->user_card_number);
                $cad[$key]['card_cvc'] = $card->user_card_cvc;
            }
            $result['cards'] = $cad;
            return $this->sendResponse($result,'Card List.');
        }
        else
        {
            return $this->sendError("No Card found", []);
        }

    }

    public function add_card(Request $request)
    {
        $rules = [
                    'card_name' => 'required',
                    'card_number' => 'required|numeric',
                    'card_expiry' => 'required',
                    'card_cvc' => 'required|digits:3',
                ];

        $messages = [
                     'card_name.required' => 'Please Enter Name',
                     'card_number.required' => 'Please Enter Card Number',
                     'card_expiry.required' => 'Please Enter Expiry',
                     'card_expiry.regex' => 'The date must be in MM/DD format, like 12/25',
                     'card_cvc.required' => 'Please Enter CVC',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $check = UserCard::where(['user_card_number'=>$request->card_number,'user_card_user'=>Auth::user()->id])->count();
            //print_r($check);exit;
            if($check == 0)
            {
                $ins['user_card_user']        = Auth::user()->id;
                $ins['user_card_name']        = $request->card_name;
                $ins['user_card_number']      = $request->card_number;
                $ins['user_card_expiry']      = $request->card_expiry;
                $ins['user_card_cvc']         = $request->card_cvc;
                $ins['user_card_added_by']    = Auth::user()->id;
                $ins['user_card_updated_by']  = Auth::user()->id;
                $ins['user_card_added_on']    = date('Y-m-d H:i:s');
                $ins['user_card_updated_on']  = date('Y-m-d H:i:s');

                $insert = UserCard::create($ins);

                return $this->sendResponse([], 'Card added Successfully.');
            }
            else
            {
                return $this->sendError([], ['error'=>'Card already in use']);
            }
        }
    }

    public function edit_card(Request $request)
    {
        $rules = [ 'card_id' => 'required',
                    'card_name' => 'required',
                    'card_number' => 'required',
                    'card_expiry' => 'required',
                    'card_cvc' => 'required',
                ];

        $messages = [
                    'card_id.required' => 'Please Provide Card ID',
                     'card_name.required' => 'Please Enter Name',
                     'card_number.required' => 'Please Enter Card Number',
                     'card_expiry.required' => 'Please Enter Expiry',
                     'card_cvc.email' => 'Please Enter CVC',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $card = UserCard::where(['user_card_user'=>Auth::user()->id,'user_card_id'=>$request->card_id])->count();
            if($card > 0)
            {
                $upd['user_card_name']        = $request->card_name;
                $upd['user_card_number']      = $request->card_number;
                $upd['user_card_expiry']      = $request->card_expiry;
                $upd['user_card_cvc']         = $request->card_cvc;
                $upd['user_card_updated_by']  = Auth::user()->id;
                $upd['user_card_updated_on']  = date('Y-m-d H:i:s');

                $update = UserCard::where('user_card_id',$request->card_id)->update($upd);

                return $this->sendResponse([], 'Card updated Successfully.');
            }
            else
            {
                return $this->sendError([], ['error'=>'Card not Found.']);
            }
        }
    }

    public function delete_card(Request $request)
    {
        $rules = [ 'card_id' => 'required',
                ];

        $messages = [
                    'card_id.required' => 'Please Provide Address id',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $cards = UserCard::where(['user_card_user'=>Auth::user()->id,'user_card_id'=>$request->card_id])->count();

        if($cards > 0)
        {
            $delete = UserCard::where('user_card_id',$request->segment(3))->delete();

            return $this->sendResponse([], 'Card Deleted Successfully.');
        }
        else
        {
            return $this->sendError([], ['error'=>'Card not Found.']);
        }
    }


}
