<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Vendor;
use App\Models\Category;

class AdminVendorController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'vendors';
        return view('admin.vendor.vendors',$data);
    }

    public function get_vendors(Request $request)
    {
        if($request->ajax())
        {
            $data = Vendor::orderby('vendor_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->vendor_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/admin/uploads/vendor/'.$row->vendor_image).'" alt="..." class="avatar-img rounded" width="50">';

                        return $image;
                    })
                    ->addColumn('status', function($row)
                    {
                        if($row->vendor_status == 1)
                        {
                            $status = '<span class="status-label text-white">Active</span>';
                        }
                        else
                        {
                            $status = '<span class="status-label text-white">Disable</span>';
                        }

                        return $status;

                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('admin/edit_vendor/'.$row->vendor_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->vendor_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/vendor_status/'.$row->vendor_id.'/'.$row->vendor_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/vendor_status/'.$row->vendor_id.'/'.$row->vendor_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_vendor(Request $request)
    {
        $data['set'] = 'vendors';
        $data['categories'] = Category::where('category_status',1)->get();
        return view('admin.vendor.add_vendor',$data);
    }

    public function create_vendor(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['vendor_email'=>'required',
                       'vendor_name' => 'required',
                       'vendor_phone' => 'required',
                       'vendor_type' => 'required'];

            $messages = ['vendor_email.required'=>'Please Enter Email',
                        'vendor_email.email'=>'Please Enter Valid Email',
                        'vendor_name.required'=>'Please enter name',
                        'vendor_phone.required'=>'Please enter phone',
                        'vendor_type.required'=>'Please choose category'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['vendor_name'] = $request->vendor_name;
            $check_name = Vendor::where($where_name)->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['vendor_name']       = $request->vendor_name;
            $ins['vendor_type']       = $request->vendor_type;
            $ins['vendor_email']      = $request->vendor_email;
            $ins['vendor_phone']      = $request->vendor_phone;
            $ins['vendor_password']   = bcrypt($request->vendor_password);
            $ins['vendor_vpassword']   = base64encode($request->vendor_password);
            $ins['vendor_status']     = 1;
            $ins['vendor_added_by']   = Auth::guard('admin')->user()->admin_id;
            $ins['vendor_added_on']   = date('Y-m-d H:i:s');
            $ins['vendor_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $ins['vendor_updated_on'] = date('Y-m-d H:i:s');
            if($request->hasFile('vendor_image'))
            {
                $vendor_image = $request->vendor_image->store('assets/vendor/uploads/profile');

                $vendor_image = explode('/',$vendor_image);
                $vendor_image = end($vendor_image);
                $ins['vendor_image'] = $vendor_image;
            }

            $insert_id = Vendor::insertGetId($ins);

            if($insert_id)
            {
                return redirect()->back()->with('success','Vendor Added Successfully');
            }
        }
    }

    public function edit_vendor(Request $request)
    {
        $data['vendor'] = Vendor::where('vendor_id',$request->segment(3))->first();

        if(!isset($data['vendor']))
        {
            return redirect('admin/vendors');
        }

        $data['set'] = 'vendors';
        return view('admin.vendor.edit_vendor',$data);
    }

    public function update_vendor(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['vendor_email'=>'required',
                       'vendor_name' => 'required',
                       'vendor_phone' => 'required',
                       'vendor_type' => 'required'];

            $messages = ['vendor_email.required'=>'Please Enter Email',
                        'vendor_email.email'=>'Please Enter Valid Email',
                        'vendor_name.required'=>'Please enter name',
                        'vendor_phone.required'=>'Please enter phone',
                        'vendor_type.required'=>'Please choose category'];


            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['vendor_name'] = $request->vendor_name;
            $check_name = Vendor::where($where_name)->where('vendor_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['vendor_name']       = $request->vendor_name;
            $upd['vendor_type']       = $request->vendor_type;
            $upd['vendor_email']      = $request->vendor_email;
            $upd['vendor_phone']      = $request->vendor_phone;
            $upd['vendor_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $upd['vendor_updated_on'] = date('Y-m-d H:i:s');
            if($request->vendor_password != NULL)
            {
                $upd['vendor_password']   = bcrypt($request->vendor_password);
                $upd['vendor_vpassword']   = base64encode($request->vendor_password);
            }

            if($request->hasFile('vendor_image'))
            {
                $vendor_image = $request->vendor_image->store('assets/vendor/uploads/profile');

                $vendor_image = explode('/',$vendor_image);
                $vendor_image = end($vendor_image);
                $upd['vendor_image'] = $vendor_image;
            }

            $update = Vendor::where('vendor_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Vendor Updated Successfully');
            }
        }
    }

    public function vendor_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['vendor_status'] = 2;
        }
        else
        {
            $upd['vendor_status'] = 1;
        }

        $where['vendor_id'] = $id;

        $update = Vendor::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }


    public function vendor_delete(Request $request)
    {
        $id = $request->segment(3);

        $upd['vendor_trash'] = 1;

        $where['vendor_id'] = $id;

        $update = Vendor::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Deleted Successfully');
        }
    }

}
