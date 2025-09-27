<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Trainer;
use App\Models\Category;

class AdminTrainerController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'trainers';
        return view('admin.trainer.trainers',$data);
    }

    public function get_trainers(Request $request)
    {
        if($request->ajax())
        {
            $data = Trainer::orderby('trainer_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->trainer_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/admin/uploads/trainer/'.$row->trainer_image).'" alt="..." class="avatar-img rounded" width="50">';

                        return $image;
                    })
                    ->addColumn('status', function($row)
                    {
                        if($row->trainer_status == 1)
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

                        $btn = '<a href="'.url('admin/edit_trainer/'.$row->trainer_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->trainer_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/trainer_status/'.$row->trainer_id.'/'.$row->trainer_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/trainer_status/'.$row->trainer_id.'/'.$row->trainer_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_trainer(Request $request)
    {
        $data['set'] = 'trainers';
        $data['categories'] = Category::where('category_status',1)->get();
        return view('admin.trainer.add_trainer',$data);
    }

    public function create_trainer(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['trainer_email'=>'required',
                       'trainer_name' => 'required',
                       'trainer_phone' => 'required',
                       'trainer_type' => 'required'];

            $messages = ['trainer_email.required'=>'Please Enter Email',
                        'trainer_email.email'=>'Please Enter Valid Email',
                        'trainer_name.required'=>'Please enter name',
                        'trainer_phone.required'=>'Please enter phone',
                        'trainer_type.required'=>'Please choose category'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['trainer_email'] = $request->trainer_email;
            $check_name = Trainer::where($where_name)->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Email already in use')->withInput();
            }

            $ins['trainer_name']       = $request->trainer_name;
            $ins['trainer_type']       = $request->trainer_type;
            $ins['trainer_email']      = $request->trainer_email;
            $ins['trainer_phone']      = $request->trainer_phone;
            $ins['trainer_password']   = bcrypt($request->trainer_password);
            $ins['trainer_vpassword']   = base64_encode($request->trainer_password);
            $ins['trainer_status']     = 1;
            $ins['trainer_added_by']   = Auth::guard('admin')->user()->admin_id;
            $ins['trainer_added_on']   = date('Y-m-d H:i:s');
            $ins['trainer_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $ins['trainer_updated_on'] = date('Y-m-d H:i:s');
            if($request->hasFile('trainer_image'))
            {
                $trainer_image = $request->trainer_image->store('assets/trainer/uploads/profile');

                $trainer_image = explode('/',$trainer_image);
                $trainer_image = end($trainer_image);
                $ins['trainer_image'] = $trainer_image;
            }

            $insert_id = Trainer::insertGetId($ins);

            if($insert_id)
            {
                return redirect()->back()->with('success','Trainer Added Successfully');
            }
        }
    }

    public function edit_trainer(Request $request)
    {
        $data['trainer'] = Trainer::where('trainer_id',$request->segment(3))->first();

        if(!isset($data['trainer']))
        {
            return redirect('admin/trainers');
        }

        $data['set'] = 'trainers';
        return view('admin.trainer.edit_trainer',$data);
    }

    public function update_trainer(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['trainer_email'=>'required',
                       'trainer_name' => 'required',
                       'trainer_phone' => 'required',
                       'trainer_type' => 'required'];

            $messages = ['trainer_email.required'=>'Please Enter Email',
                        'trainer_email.email'=>'Please Enter Valid Email',
                        'trainer_name.required'=>'Please enter name',
                        'trainer_phone.required'=>'Please enter phone',
                        'trainer_type.required'=>'Please choose category'];


            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['trainer_email'] = $request->trainer_email;
            $check_name = Trainer::where($where_name)->where('trainer_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Email already in use')->withInput();
            }

            $upd['trainer_name']       = $request->trainer_name;
            $upd['trainer_type']       = $request->trainer_type;
            $upd['trainer_email']      = $request->trainer_email;
            $upd['trainer_phone']      = $request->trainer_phone;
            $upd['trainer_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $upd['trainer_updated_on'] = date('Y-m-d H:i:s');
            if($request->trainer_password != NULL)
            {
                $upd['trainer_password']   = bcrypt($request->trainer_password);
                $upd['trainer_vpassword']   = base64encode($request->trainer_password);
            }

            if($request->hasFile('trainer_image'))
            {
                $trainer_image = $request->trainer_image->store('assets/trainer/uploads/profile');

                $trainer_image = explode('/',$trainer_image);
                $trainer_image = end($trainer_image);
                $upd['trainer_image'] = $trainer_image;
            }

            $update = Trainer::where('trainer_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Trainer Updated Successfully');
            }
        }
    }

    public function trainer_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['trainer_status'] = 2;
        }
        else
        {
            $upd['trainer_status'] = 1;
        }

        $where['trainer_id'] = $id;

        $update = Trainer::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }


    public function trainer_delete(Request $request)
    {
        $id = $request->segment(3);

        $upd['trainer_trash'] = 1;

        $where['trainer_id'] = $id;

        $update = Trainer::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Deleted Successfully');
        }
    }

}
