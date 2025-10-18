<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Helper;
use Validator;
use App\Models\User;

class UserRegisterController extends BaseController
{
    public function index(Request $request)
    {
        $rules = ['fname' => 'required',
                    'lname' => 'required',
                    'email' => 'required',
                    'uname'=> 'required',
                    'password'=>'required',
                    'terms' => 'required|digits:1'];

        $messages = ['fname.required'=>'Please enter first name',
                     'lname.required'=>'Please enter last name',
                    'email.required'=>'Please enter email',
                    'uname.required'=>'Please enter user name',
                    'password.required'=>'Please enter Password',
                    'terms.required'=>'Please accept the terms',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        $checkEmail = User::where('email',$request->email)->count();
        $checkUsername = User::where('uname',$request->uname)->count();
        if($checkEmail > 0)
        {
            return $this->sendError([], ['error'=>'Email Id already in use']);
        }
        if($checkUsername > 0)
        {
            return $this->sendError([], ['error'=>'User Name already in use']);
        }

        $ins['fname']    = $request->fname;
        $ins['lname']    = $request->lname;
        $ins['email']    = $request->email;
        $ins['uname']    = $request->uname;
        $ins['role']     = 2;
        $ins['password'] = bcrypt($request->password);
        $ins['created_at'] = date('Y-m-d H:i:s');
        $ins['updated_at'] = date('Y-m-d H:i:s');

        $insert_id = User::insertGetId($ins);

        if($insert_id)
        {

            $user = User::find($insert_id);
            $result['token'] = $user->createToken('Splt')-> accessToken;
            $result['name'] = $user->fname.' '.$user->lname;

            return $this->sendResponse($result, "User registerd successfully.");
        }

    }

    public function verify_mobile(Request $request)
    {
        $rules = ['otp' => 'required|digits:6'];

        $messages = ['otp.required' => 'Please Enter OTP'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $otp = $request->otp;
            $verify_otp = Auth::user()->otp;

            if($otp == $verify_otp)
            {
                $upd['mobile_verify'] = 1;
                $upd['otp']   = NULL;
                $update = User::where(['id'=>Auth::user()->id])->update($upd);

                $result['otp_verify'] = 1;
                return $this->sendResponse($result, 'OTP verified successfully.');
            }
            else
            {
                $result['otp_verify'] = 0;
                return $this->sendError($result, ['error'=>'Please verify OTP']);
            }
        }
    }

    public function get_otp(Request $request)
    {
        $mobile = '91'.Auth::user()->mobile;
        $otp = random_int(100000, 999999);
        $data['mobile'] = '91'.$mobile;
        $data['message'] = $otp.' is your verification code. For your security, do not share this code.';
        $data['api_key'] = $request->sms_settings->sms_setting_appkey;

        $upd['otp'] = $otp;
        $upd['mobile_verify_within'] = strtotime(date('Y-m-d H:i:s')) + 60;

        $update = User::where('id',Auth::user()->id)->update($upd);

        $status = Helper::sendMessage($data);

        $data1['auth_key'] = $request->sms_settings->sms_setting_key;
        $data1['mobile'] = $mobile;
        $data1['otp'] = $otp;

        $sms_status = Helper::sendSMS($data1);

        if(isset($status) && $status == true)
        {
            $result['mobile'] = $mobile;
            $result['otp_sent'] = "Success";
            return $this->sendResponse($result, 'OTP sent successfully');
        }
        elseif(isset($sms_status) && $sms_status == true)
        {
            $result['mobile'] = $mobile;
            $result['otp_sent'] = "Success";
            return $this->sendResponse($result, 'OTP sent successfully');
        }
        else
        {
            $result['mobile'] = $mobile;
            $result['otp_sent'] = "Failed";
            return $this->sendResponse($result, "Couldn't sent OTP. Please contact Admin.");
        }
    }

    public function change_mobile_number(Request $request)
    {
        $rules = ['new_mobile'=> 'required|digits:10'];

        $messages = ['new_mobile.required'=>'Please enter mobile number'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $new_otp = random_int(100000, 999999);

        $upd['mobile'] = $request->new_mobile;
        $upd['mobile_verify'] = 0;
        $upd['otp'] = $new_otp;
        $upd['mobile_verify_within'] = strtotime(date('Y-m-d H:i:s')) + 60;

        $update = User::where('id',Auth::user()->id)->update($upd);

        if($update)
        {
            $mobile = '91'.$request->new_mobile;
            $data['mobile'] = '91'.$mobile;
            $data['message'] = $new_otp.' is your verification code. For your security, do not share this code.';
            $data['api_key'] = $request->sms_settings->sms_setting_appkey;

            $status = Helper::sendMessage($data);

            $data1['auth_key'] = $request->sms_settings->sms_setting_key;
            $data1['mobile'] = $request->mobile;
            $data1['otp'] = $ins['otp'];

            $sms_status = Helper::sendSMS($data1);

            if(isset($status) && $status == true)
            {
                return $this->sendResponse([], 'OTP sent to New Mobile Number. Please check your mobile.');
            }
            elseif(isset($sms_status) && $sms_status == true)
            {
                return $this->sendResponse([], 'OTP sent to New Mobile Number. Please check your mobile.');
            }
            else
            {
                return $this->sendError('Could not sent OTP. Please contact Admin', []);
            }
        }
    }



}
