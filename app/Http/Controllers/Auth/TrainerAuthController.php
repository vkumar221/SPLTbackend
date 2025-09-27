<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trainer;
use Auth;
use Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Hash;

class TrainerAuthController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Login';
        return view('trainer.login.login', $data);
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'trainer_email' => 'required|email',
            'trainer_password' => 'required',
        ]);

        if(Auth::guard('trainer')->attempt(['trainer_email' => $request->trainer_email, 'password' => $request->trainer_password])){
            if(Auth::guard('trainer')->user()->trainer_status == 1){
                return redirect()->route('trainer.dashboard-page')->with('success', 'Logged in successfully');
            }else{
                Auth::guard('trainer')->logout();
                return redirect()->route('trainer.login-page')->with('success', "Sorry you don't have the access");
            }
        }else{
            return redirect()->back()
                ->withInput($request->only('trainer_email'))
                ->withErrors([
                    'trainer_email' => 'Invalid username or password',
                ]);
        }
    }

    public function forgotPasswordEmail(Request $request)
    {
        $data['title'] = 'Forgot Password';
        return view('trainer.login.forgot_password', $data);
    }

    public function forgotPasswordEmailCheck(Request $request)
    {
        $request->validate([
            'trainer_email' => 'required',
        ]);
        $findUser = Trainer::where('trainer_email', $request->trainer_email);
        if($findUser->count() > 0){
            try {
                $data['name'] = $findUser->first()->trainer_name;
                $data['link'] = @route('trainer.forgot-password-page',['token' => base64_encode($findUser->first()->trainer_id)]);
                Mail::to($findUser->first()->trainer_email)->send(new PasswordResetMail($data));
                return redirect()->route('trainer.forgot-password-email-page')->with('success', "Password reset link sent successfully");
            } catch (Exception $e) {
                return redirect()->route('trainer.forgot-password-email-page')->with('error', "Oops something went wrong");
            }
        }else{
            return redirect()->route('trainer.login-page')->with('error', 'User not found please register');
        }
    }

    public function forgotPassword(Request $request, $token)
    {
        $userId = base64_decode($token);
        $findUser = Trainer::where('trainer_id', $userId);
        if($findUser->count() == 0){
            return redirect()->route('trainer.forgot-password-email-page')->with('error', "Invalid token");
        }
        $data['title'] = 'Forgot Password';
        $data['trainer'] = $findUser->first();
        return view('auth.forgot-password', $data);
    }

    public function updateForgotPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $findUser = Trainer::where('trainer_email', $request->trainer_email);
        if($findUser->count() > 0){
            try {
                $findUser->update(['trainer_password'=>Hash::make($request->confirm_password)]);
                return redirect()->route('trainer.login-page')->with('success', "Password updated successfully");
            } catch (Exception $e) {
                return redirect()->route('trainer.forgot-password-page',['token' => base64_encode($findUser->first()->trainer_id)])->with('error', "Oops something went wrong");
            }
        }else{
            return redirect()->route('trainer.login-page')->with('error', 'User not found please register');
        }
    }
}
