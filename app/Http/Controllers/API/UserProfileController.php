<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Auth;
use Hash;
use Validator;
use App\Models\User;

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
}
