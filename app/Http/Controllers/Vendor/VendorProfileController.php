<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Vendor;

class VendorProfileController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'profile';
        return view('vendor.profile.profile',$data);
    }

    public function update_profile(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['vendor_name' => 'required',
                      'vendor_email' => 'required|email',
                      'vendor_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                      ];

            $messages = ['vendor_name.required' => 'Please Enter Name',
                         'vendor_email.required' => 'Please Enter Email Address',
                         'vendor_email.email' => 'Please Enter Valid Email Address',
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            //print_r($validator->errors());exit;

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_email['vendor_email'] = $request->vendor_email;

                $check_email = Vendor::where($where_email)->where('vendor_id','!=',Auth::guard('vendor')->user()->vendor_id)->count();

                if($check_email > 0)
                {
                    return redirect()->back()->with('error','Email Address Already Exists')->withInput();
                }

                $upd['vendor_name']       = $request->vendor_name;
                $upd['vendor_email']      = $request->vendor_email;
                $upd['vendor_updated_on'] = date('Y-m-d H:i:s');
                $upd['vendor_updated_by'] = Auth::guard('vendor')->user()->vendor_id;

                if($request->hasFile('vendor_image'))
                {
                    $vendor_image = $request->vendor_image->store('assets/vendor/uploads/profile');

                    $vendor_image = explode('/',$vendor_image);
                    $vendor_image = end($vendor_image);
                    $upd['vendor_image'] = $vendor_image;
                }

                $vendor = Vendor::where('vendor_id',Auth::guard('vendor')->user()->vendor_id)->update($upd);

                return redirect()->back()->with('success','Details Updated Successfully');
            }
        }
    }

    public function change_password(Request $request)
    {
        $data['set'] = 'change_password';
        return view('vendor.profile.change_password',$data);
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
                $where['vendor_id'] = Auth::guard('vendor')->user()->vendor_id;
                $where['vendor_vpassword'] = base64_encode($request->current_password);

                $check = Vendor::where($where)->count();

                if($check > 0)
                {
                    $upd['vendor_password']   = bcrypt($request->confirm_password);
                    $upd['vendor_vpassword']  = base64_encode($request->confirm_password);
                    $upd['vendor_updated_on'] = date('Y-m-d H:i:s');
                    $upd['vendor_updated_by'] = Auth::guard('vendor')->user()->vendor_id;

                    $update = Vendor::where('vendor_id',Auth::guard('vendor')->user()->vendor_id)->update($upd);

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
        $where['vendor_id']  = Auth::guard('vendor')->user()->vendor_id;
        $where['vendor_vpassword'] = base64_encode($request->old_password);

        $check = Vendor::where($where)->count();

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
