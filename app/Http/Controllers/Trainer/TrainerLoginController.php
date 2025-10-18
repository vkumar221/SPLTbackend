<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Mail;
use App\Models\Trainer;

class TrainerLoginController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'login';
        return view('trainer.login.login',$data);
    }

    public function login(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['trainer_email' => 'required|email',
                      'trainer_password' => 'required'];

            $messages = ['trainer_email.required' => 'Please Enter Email Address',
                         'trainer_email.email' => 'Please Enter Valid Email Address',
                         'trainer_password.required' => 'Please Enter Password'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['trainer_email'] = $request->trainer_email;
                $where['password'] = $request->trainer_password;

                if(Auth::guard('trainer')->attempt($where))
                {
                    if(Auth::user()->status == 1)
                    {
                        return redirect('trainer/dashboard');
                    }
                    else
                    {
                        Auth::guard('trainer')->logout();

                        return redirect('trainer')->with('error','Invalid Email or Password!')->withInput();
                    }
                }
                else
                {
                    return redirect('trainer')->with('error','Invalid Email or Password!')->withInput();
                }
            }
        }
    }

    public function forgot_password(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['trainer_email' => 'required|email'];

            $messages = ['trainer_email.required' => 'Please Enter Email Address',
                         'trainer_email.email' => 'Please Enter Valid Email Address',
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $trainer = Trainer::where('trainer_email',$request->trainer_email)->first();

                if(isset($trainer))
                {
                    $mail  = $request->trainer_email;

                    $uname = $data['name'] = $trainer->trainer_name;

                    $encryptedValue = Crypt::encryptString('userid='.$user->user_id);
                    $data['reset_link'] = url('reset_password/'.$encryptedValue);
                    $data['site_name'] = config('constants.site_title');

                    $send = Mail::send('trainer.mail.forgot_password', $data, function($message) use ($mail, $uname){
                         $message->to($mail, $uname)->subject(config('constants.site_title').' - Forgot Password');
                         $message->from(config('constants.mail_from'),config('constants.site_title'));
                      });

                    return redirect('trainer')->with('success','Please Check Your Email');
                }
                else
                {
                    return redirect('trainer_forgot_password')->with('error','Invalid Email Address')->withInput();
                }
            }
        }

        $data['set'] = 'forgot_password';
        return view('trainer.login.forgot_password',$data);
    }

    public function reset_password(Request $request)
    {
        $encryptedValue = $request->segment(2);
        $decryptedValue = Crypt::decryptString($encryptedValue);
        $arr = explode('=',$decryptedValue);
        $trainer_id = $arr[1];
        $trainer = Trainer::where('trainer_id',$trainer_id)->first();
        if(strtotime(date('Y-m-d H:i:s')) > $trainer->trainer_reset_by)
        {
            return redirect('trainer')->with('error','The Password Reset Link Expired');
        }
        if($request->has('trainer_password'))
        {
            $rules = [
                      'trainer_password' => 'required|min:6',
                      'trainer_cpassword' => 'required|same:trainer_password',];

            $messages = [
                         'trainer_password.required' => 'Please Enter Password',
                         'trainer_password.min' => 'Please Enter atleast 6 characters',
                         'trainer_cpassword.required' => 'Please Enter Password again',
                         'trainer_cpassword.same' => 'Please verify password'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {

                if(isset($trainer))
                {
                    $upd['trainer_password'] = bcrypt($request->trainer_password);
                    $upd['trainer_vpassword'] = base64_encode($request->trainer_password);
                    $upd['trainer_updated_on'] = date('Y-m-d H:i:s');
                    $upd['trainer_reset_by'] = strtotime(date('Y-m-d H:i:s'));

                    $update = trainer::where('trainer_id',$trainer_id)->update($upd);
                    return redirect('login')->with('success','Password reset successfully');
                }
                else
                {
                    return redirect()->back()->with('error','Something went Wrong');
                }
            }
        }

        $data['set'] = 'reset_password';
        $data['email'] = $trainer->user_email;
        return view('website.login.reset_password',$data);
    }

}
