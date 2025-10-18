<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Hash;

class VendorAuthController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Login';
        return view('vendor.login.login', $data);
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->status == 1 && Auth::user()->role == 3){
                return redirect()->route('vendor.dashboard-page')->with('success', 'Logged in successfully');
            }else{
                Auth::logout();
                return redirect()->route('vendor.login-page')->with('success', "Sorry you don't have the access");
            }
        }else{
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Invalid username or password',
                ]);
        }
    }

    public function forgotPasswordEmail(Request $request)
    {
        $data['title'] = 'Forgot Password';
        return view('vendor.login.forgot_password', $data);
    }

    public function forgotPasswordEmailCheck(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        $findUser = User::where('email', $request->email);
        if($findUser->count() > 0){
            try {
                $data['name'] = $findUser->first()->name;
                $data['link'] = @route('vendor.forgot-password-page',['token' => base64_encode($findUser->first()->id)]);
                Mail::to($findUser->first()->email)->send(new PasswordResetMail($data));
                return redirect()->route('vendor.forgot-password-email-page')->with('success', "Password reset link sent successfully");
            } catch (Exception $e) {
                return redirect()->route('vendor.forgot-password-email-page')->with('error', "Oops something went wrong");
            }
        }else{
            return redirect()->route('vendor.login-page')->with('error', 'User not found please register');
        }
    }

    public function forgotPassword(Request $request, $token)
    {
        $userId = base64_decode($token);
        $findUser = User::where('id', $userId);
        if($findUser->count() == 0){
            return redirect()->route('vendor.forgot-password-email-page')->with('error', "Invalid token");
        }
        $data['title'] = 'Forgot Password';
        $data['vendor'] = $findUser->first();
        return view('auth.forgot-password', $data);
    }

    public function updateForgotPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $findUser = User::where('email', $request->email);
        if($findUser->count() > 0){
            try {
                $findUser->update(['password'=>Hash::make($request->confirm_password)]);
                return redirect()->route('vendor.login-page')->with('success', "Password updated successfully");
            } catch (Exception $e) {
                return redirect()->route('vendor.forgot-password-page',['token' => base64_encode($findUser->first()->vendor_id)])->with('error', "Oops something went wrong");
            }
        }else{
            return redirect()->route('vendor.login-page')->with('error', 'User not found please register');
        }
    }
}
