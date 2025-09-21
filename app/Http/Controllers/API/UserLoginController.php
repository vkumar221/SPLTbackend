<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Auth;
use Validator;
use Helper;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class UserLoginController extends BaseController
{
    public function index(Request $request)
    {
        $rules = ['email' => 'required|email',
                  'password' => 'required'];

        $messages = ['email.required' => 'Please Enter Email',
                     'email.email' => 'Please Enter Valid Email',
                     'password.required' => 'Please Enter Password'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $where['email'] = $request->email;
            $where['password'] = $request->password;

            if(Auth::attempt($where))
            {
                $user = Auth::user();
                $result['token'] = $user->createToken('Splt')-> accessToken;
                $result['name'] = $user->name;

                return $this->sendResponse($result, 'User login successfully.');
            }
            else
            {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();

        return $this->sendResponse([], 'User logout successfully.');
    }

    public function logout_all_device(Request $request)
    {
        $tokens =  Auth::user()->tokens->pluck('id');
        Token::whereIn('id', $tokens)
            ->update(['revoked'=> true]);

        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);

        return $this->sendResponse([], 'User logout from all devices.');
    }

    public function forgot_password(Request $request)
    {
        $rules = ['email'=> 'required|email'];

        $messages = ['email.required'=>'Please enter email id'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $email = $request->email;

        $user = User::where('email',$email)->first();

        if(isset($user))
        {
            //$new_otp = random_int(100000, 999999);
            $new_otp = 1234;
            $upd['otp'] = $new_otp;
            $upd['verify_within'] = strtotime(date('Y-m-d H:i:s')) + 60;

            $update = User::where('id',$user->id)->update($upd);

            if($update)
            {
                $data['email'] = $email;
                $data['message'] = $new_otp.' is your verification code. For your security, do not share this code.';

                // $status = Helper::sendMail($data);
                $status = true;

                if(isset($status) && $status == true)
                {
                    $result['email'] = $email;
                    return $this->sendResponse($result, 'OTP Sent to email. Please verify to reset password.');
                }
                else
                {
                    return $this->sendError('Could not sent OTP. Please contact Admin', []);
                }
            }

        }
        else
        {
            return $this->sendError('Email ID not found', []);
        }
    }

    public function reset_password(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required',
             'confirm_password' => 'required' ];

        $messages = ['email.required' => 'Please enter email',
                    'otp.required' => 'Please Provide OTP',
                    'password.required' => 'Please Enter Password',
                    'confirm_password.required' => 'Please Enter Password Again',
                    ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }
        else
        {
            $otp = $request->otp;
            $email = $request->email;
            $user = User::where('email',$email)->first();
            if(isset($user))
            {
                $verify_otp = $user->otp;

                if(strtotime('now') <= $user->verify_within)
                {
                    if($request->password == $request->confirm_password)
                    {
                        if($otp == $verify_otp)
                        {
                            $upd['password'] = bcrypt($request->password);
                            $upd['otp']   = NULL;
                            $upd['verify_within'] = strtotime('now');
                            $update = User::where(['id'=>$user->id])->update($upd);

                            $tokens =  $user->tokens->pluck('id');
                            Token::whereIn('id', $tokens)
                                ->update(['revoked'=> true]);

                            RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);

                            return $this->sendResponse([], 'Password Changed Successfully.');
                        }
                        else
                        {
                            return $this->sendError('Invalid OTP', []);
                        }
                    }
                    else
                    {
                        return $this->sendError('Password Mismatched', []);
                    }
                }
                else
                {
                    return $this->sendError('Timeout. Please generate new otp', []);
                }
            }
            else
            {
                return $this->sendError('Invalid Token', []);
            }
        }
    }
}
