<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Mail;
use App\Models\Vendor;

class VendorLoginController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'login';
        return view('vendor.login.login',$data);
    }

    public function login(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['vendor_email' => 'required|email',
                      'vendor_password' => 'required'];

            $messages = ['vendor_email.required' => 'Please Enter Email Address',
                         'vendor_email.email' => 'Please Enter Valid Email Address',
                         'vendor_password.required' => 'Please Enter Password'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['vendor_email'] = $request->vendor_email;
                $where['password'] = $request->vendor_password;

                if(Auth::guard('vendor')->attempt($where))
                {
                    if(Auth::user()->status == 1)
                    {
                        return redirect('vendor/dashboard');
                    }
                    else
                    {
                        Auth::guard('vendor')->logout();

                        return redirect('vendor')->with('error','Invalid Email or Password!')->withInput();
                    }
                }
                else
                {
                    return redirect('vendor')->with('error','Invalid Email or Password!')->withInput();
                }
            }
        }
    }

    public function forgot_password(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['vendor_email' => 'required|email'];

            $messages = ['vendor_email.required' => 'Please Enter Email Address',
                         'vendor_email.email' => 'Please Enter Valid Email Address',
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $vendor = Vendor::where('vendor_email',$request->vendor_email)->first();

                if(isset($vendor))
                {
                    $mail  = $request->vendor_email;

                    $uname = $data['name'] = $vendor->vendor_name;

                    $encryptedValue = Crypt::encryptString('userid='.$user->user_id);
                    $data['reset_link'] = url('reset_password/'.$encryptedValue);
                    $data['site_name'] = config('constants.site_title');

                    $send = Mail::send('vendor.mail.forgot_password', $data, function($message) use ($mail, $uname){
                         $message->to($mail, $uname)->subject(config('constants.site_title').' - Forgot Password');
                         $message->from(config('constants.mail_from'),config('constants.site_title'));
                      });

                    return redirect('vendor')->with('success','Please Check Your Email');
                }
                else
                {
                    return redirect('vendor_forgot_password')->with('error','Invalid Email Address')->withInput();
                }
            }
        }

        $data['set'] = 'forgot_password';
        return view('vendor.login.forgot_password',$data);
    }

    public function reset_password(Request $request)
    {
        $encryptedValue = $request->segment(2);
        $decryptedValue = Crypt::decryptString($encryptedValue);
        $arr = explode('=',$decryptedValue);
        $vendor_id = $arr[1];
        $vendor = Vendor::where('vendor_id',$vendor_id)->first();
        if(strtotime(date('Y-m-d H:i:s')) > $vendor->vendor_reset_by)
        {
            return redirect('vendor')->with('error','The Password Reset Link Expired');
        }
        if($request->has('vendor_password'))
        {
            $rules = [
                      'vendor_password' => 'required|min:6',
                      'vendor_cpassword' => 'required|same:vendor_password',];

            $messages = [
                         'vendor_password.required' => 'Please Enter Password',
                         'vendor_password.min' => 'Please Enter atleast 6 characters',
                         'vendor_cpassword.required' => 'Please Enter Password again',
                         'vendor_cpassword.same' => 'Please verify password'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {

                if(isset($vendor))
                {
                    $upd['vendor_password'] = bcrypt($request->vendor_password);
                    $upd['vendor_vpassword'] = base64_encode($request->vendor_password);
                    $upd['vendor_updated_on'] = date('Y-m-d H:i:s');
                    $upd['vendor_reset_by'] = strtotime(date('Y-m-d H:i:s'));

                    $update = vendor::where('vendor_id',$vendor_id)->update($upd);
                    return redirect('login')->with('success','Password reset successfully');
                }
                else
                {
                    return redirect()->back()->with('error','Something went Wrong');
                }
            }
        }

        $data['set'] = 'reset_password';
        $data['email'] = $vendor->user_email;
        return view('website.login.reset_password',$data);
    }

}
