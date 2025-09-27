<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Trainer;

class TrainerProfileController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'profile';
        return view('trainer.profile.profile',$data);
    }

    public function update_profile(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['trainer_name' => 'required',
                      'trainer_email' => 'required|email',
                      'trainer_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                      ];

            $messages = ['trainer_name.required' => 'Please Enter Name',
                         'trainer_email.required' => 'Please Enter Email Address',
                         'trainer_email.email' => 'Please Enter Valid Email Address',
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            //print_r($validator->errors());exit;

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_email['trainer_email'] = $request->trainer_email;

                $check_email = Trainer::where($where_email)->where('trainer_id','!=',Auth::guard('trainer')->user()->trainer_id)->count();

                if($check_email > 0)
                {
                    return redirect()->back()->with('error','Email Address Already Exists')->withInput();
                }

                $upd['trainer_name']       = $request->trainer_name;
                $upd['trainer_email']      = $request->trainer_email;
                $upd['trainer_updated_on'] = date('Y-m-d H:i:s');
                $upd['trainer_updated_by'] = Auth::guard('trainer')->user()->trainer_id;

                if($request->hasFile('trainer_image'))
                {
                    $trainer_image = $request->trainer_image->store('assets/trainer/uploads/profile');

                    $trainer_image = explode('/',$trainer_image);
                    $trainer_image = end($trainer_image);
                    $upd['trainer_image'] = $trainer_image;
                }

                $trainer = Trainer::where('trainer_id',Auth::guard('trainer')->user()->trainer_id)->update($upd);

                return redirect()->back()->with('success','Details Updated Successfully');
            }
        }
    }

    public function change_password(Request $request)
    {
        $data['set'] = 'change_password';
        return view('trainer.profile.change_password',$data);
    }

    public function update_password(Request $request)
    {
        if($request->has('submit'))
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
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['trainer_id'] = Auth::guard('trainer')->user()->trainer_id;
                $where['trainer_vpassword'] = base64_encode($request->current_password);

                $check = Trainer::where($where)->count();

                if($check > 0)
                {
                    $upd['trainer_password']   = bcrypt($request->confirm_password);
                    $upd['trainer_vpassword']  = base64_encode($request->confirm_password);
                    $upd['trainer_updated_on'] = date('Y-m-d H:i:s');
                    $upd['trainer_updated_by'] = Auth::guard('trainer')->user()->trainer_id;

                    $update = Trainer::where('trainer_id',Auth::guard('trainer')->user()->trainer_id)->update($upd);

                    return redirect()->back()->with('success','Password Changed Successfully');
                }
                else
                {
                    return redirect()->back()->with('error','Old Password Does Not Match');
                }
            }
        }

    }
    public function check_old_password(Request $request)
    {
        $where['trainer_id']  = Auth::guard('trainer')->user()->trainer_id;
        $where['trainer_vpassword'] = base64_encode($request->old_password);

        $check = Trainer::where($where)->count();

        if($check > 0)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }
}
