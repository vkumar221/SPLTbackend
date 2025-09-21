<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Mail;
use App\Models\Admin;

class AdminLoginController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'login';
        return view('admin.login.login',$data);
    }

    public function login(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['admin_email' => 'required|email',
                      'admin_password' => 'required'];

            $messages = ['admin_email.required' => 'Please Enter Email Address',
                         'admin_email.email' => 'Please Enter Valid Email Address',
                         'admin_password.required' => 'Please Enter Password'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['admin_email'] = $request->admin_email;
                $where['password'] = $request->admin_password;

                if(Auth::guard('admin')->attempt($where))
                {
                    if(Auth::guard('admin')->user()->admin_status == 1)
                    {
                        return redirect('admin/dashboard');
                    }
                    else
                    {
                        Auth::guard('admin')->logout();

                        return redirect('admin')->with('error','Invalid Email or Password!')->withInput();
                    }
                }
                else
                {
                    return redirect('admin')->with('error','Invalid Email or Password!')->withInput();
                }
            }
        }
    }

    public function forgot_password(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['admin_email' => 'required|email'];

            $messages = ['admin_email.required' => 'Please Enter Email Address',
                         'admin_email.email' => 'Please Enter Valid Email Address',
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $admin = Admin::where('admin_email',$request->admin_email)->first();

                if(isset($admin))
                {
                    $mail  = $request->admin_email;

                    $uname = $data['name'] = $admin->admin_name;

                    $encryptedValue = Crypt::encryptString('userid='.$user->user_id);
                    $data['reset_link'] = url('reset_password/'.$encryptedValue);
                    $data['site_name'] = config('constants.site_title');

                    $send = Mail::send('admin.mail.forgot_password', $data, function($message) use ($mail, $uname){
                         $message->to($mail, $uname)->subject(config('constants.site_title').' - Forgot Password');
                         $message->from(config('constants.mail_from'),config('constants.site_title'));
                      });

                    return redirect('admin')->with('success','Please Check Your Email');
                }
                else
                {
                    return redirect('admin_forgot_password')->with('error','Invalid Email Address')->withInput();
                }
            }
        }

        $data['set'] = 'forgot_password';
        return view('admin.login.forgot_password',$data);
    }

    public function reset_password(Request $request)
    {
        $encryptedValue = $request->segment(2);
        $decryptedValue = Crypt::decryptString($encryptedValue);
        $arr = explode('=',$decryptedValue);
        $admin_id = $arr[1];
        $admin = Admin::where('admin_id',$admin_id)->first();
        if(strtotime(date('Y-m-d H:i:s')) > $admin->admin_reset_by)
        {
            return redirect('admin')->with('error','The Password Reset Link Expired');
        }
        if($request->has('admin_password'))
        {
            $rules = [
                      'admin_password' => 'required|min:6',
                      'admin_cpassword' => 'required|same:admin_password',];

            $messages = [
                         'admin_password.required' => 'Please Enter Password',
                         'admin_password.min' => 'Please Enter atleast 6 characters',
                         'admin_cpassword.required' => 'Please Enter Password again',
                         'admin_cpassword.same' => 'Please verify password'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {

                if(isset($admin))
                {
                    $upd['admin_password'] = bcrypt($request->admin_password);
                    $upd['admin_vpassword'] = base64_encode($request->admin_password);
                    $upd['admin_updated_on'] = date('Y-m-d H:i:s');
                    $upd['admin_reset_by'] = strtotime(date('Y-m-d H:i:s'));

                    $update = admin::where('admin_id',$admin_id)->update($upd);
                    return redirect('login')->with('success','Password reset successfully');
                }
                else
                {
                    return redirect()->back()->with('error','Something went Wrong');
                }
            }
        }

        $data['set'] = 'reset_password';
        $data['email'] = $admin->user_email;
        return view('website.login.reset_password',$data);
    }

}
