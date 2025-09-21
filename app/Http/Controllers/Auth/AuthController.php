<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Login';
        return view('admin.login.login', $data);
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email',
            'admin_password' => 'required',
        ]);
        
        if(Auth::guard('admin')->attempt(['admin_email' => $request->admin_email, 'password' => $request->admin_password])){
            if(Auth::guard('admin')->user()->admin_status == 1){
                return redirect()->route('admin.dashboard-page')->with('success', 'Logged in successfully');
            }else{
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login-page')->with('success', "Sorry you don't have the access");
            }
        }else{
            return redirect()->back()
                ->withInput($request->only('admin_email'))
                ->withErrors([
                    'admin_email' => 'Invalid username or password',
                ]);
        }
    }

    public function forgotPasswordEmail(Request $request)
    {
        $data['title'] = 'Forgot Password';
        return view('admin.login.forgot_password', $data);
    }

    public function forgotPasswordEmailCheck(Request $request)
    {
        $request->validate([
            'admin_email' => 'required',
        ]);
        $findUser = Admin::where('admin_email', $request->admin_email);
        if($findUser->count() > 0){
            try {
                $data['name'] = $findUser->first()->admin_name;
                $data['link'] = @route('admin.forgot-password-page',['token' => base64_encode($findUser->first()->admin_id)]);
                Mail::to($findUser->first()->admin_email)->send(new PasswordResetMail($data));
                return redirect()->route('admin.forgot-password-email-page')->with('success', "Password reset link sent successfully");
            } catch (Exception $e) {
                return redirect()->route('admin.forgot-password-email-page')->with('error', "Oops something went wrong");
            }
        }else{
            return redirect()->route('admin.login-page')->with('error', 'User not found please register');
        }
    }

    public function forgotPassword(Request $request, $token)
    {
        $userId = base64_decode($token);
        $findUser = Admin::where('admin_id', $userId);
        if($findUser->count() == 0){
            return redirect()->route('admin.forgot-password-email-page')->with('error', "Invalid token");
        }
        $data['title'] = 'Forgot Password';
        $data['admin'] = $findUser->first();
        return view('auth.forgot-password', $data);
    }

    public function updateForgotPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $findUser = Admin::where('admin_email', $request->admin_email);
        if($findUser->count() > 0){
            try {
                $findUser->update(['admin_password'=>Hash::make($request->confirm_password)]);
                return redirect()->route('admin.login-page')->with('success', "Password updated successfully");
            } catch (Exception $e) {
                return redirect()->route('admin.forgot-password-page',['token' => base64_encode($findUser->first()->admin_id)])->with('error', "Oops something went wrong");
            }
        }else{
            return redirect()->route('admin.login-page')->with('error', 'User not found please register');
        }
    }
}
