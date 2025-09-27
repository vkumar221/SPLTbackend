<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\WorkoutCategory;

class AdminWorkoutCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'workout_categories';
        $data['workout_categories'] = WorkoutCategory::orderby('workout_category_id','asc')->paginate(10);
        return view('admin.workout_category.workout_categories',$data);
    }

    public function get_workout_categories(Request $request)
    {
        if($request->ajax())
        {
            $data = WorkoutCategory::orderby('workout_category_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->workout_category_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/admin/uploads/workout_category/'.$row->workout_category_image).'" alt="..." class="avatar-img rounded" height="50">';

                        return $image;
                    })
                    ->addColumn('status', function($row)
                    {
                        if($row->workout_category_status == 1)
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

                        $btn = '<a href="'.url('admin/edit_workout_category/'.$row->workout_category_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->workout_category_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/workout_category_status/'.$row->workout_category_id.'/'.$row->workout_category_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/workout_category_status/'.$row->workout_category_id.'/'.$row->workout_category_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_workout_category(Request $request)
    {
        $data['set'] = 'workout_categories';
        return view('admin.workout_category.add_workout_category',$data);
    }

    public function create_workout_category (Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['workout_category_image'=>'required|image|mimes:jpeg,jpg,png,gif',
                       'workout_category_name' => 'required'];

            $messages = ['workout_category_image.required'=>'Please choose image',
                        'workout_category_name.required'=>'Please enter name'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['workout_category_slug'] = Str::slug($request->workout_category_name);
            $check_name = WorkoutCategory::where($where_name)->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['workout_category_name']        = $request->workout_category_name;
            $ins['workout_category_slug']        = Str::slug($request->workout_category_name);
            $ins['workout_category_description'] = $request->workout_category_description;
            $ins['workout_category_status']     = 1;
            $ins['workout_category_added_by']   = Auth::guard('admin')->user()->admin_id;
            $ins['workout_category_added_on']   = date('Y-m-d H:i:s');
            $ins['workout_category_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $ins['workout_category_updated_on'] = date('Y-m-d H:i:s');
            if($request->hasFile('workout_category_image'))
            {
                $workout_category_image = $request->workout_category_image->store('assets/admin/uploads/workout_category');

                $workout_category_image = explode('/',$workout_category_image);
                $workout_category_image = end($workout_category_image);
                $ins['workout_category_image'] = $workout_category_image;
            }
            if($request->hasFile('workout_category_cover_image'))
            {
                $workout_category_cover_image = $request->workout_category_cover_image->store('assets/admin/uploads/workout_category');

                $workout_category_cover_image = explode('/',$workout_category_cover_image);
                $workout_category_cover_image = end($workout_category_cover_image);
                $ins['workout_category_cover_image'] = $workout_category_cover_image;
            }
            if($request->hasFile('workout_category_feature_image'))
            {
                $workout_category_feature_image = $request->workout_category_feature_image->store('assets/admin/uploads/workout_category');

                $workout_category_feature_image = explode('/',$workout_category_feature_image);
                $workout_category_feature_image = end($workout_category_feature_image);
                $ins['workout_category_feature_image'] = $workout_category_feature_image;
            }

            $insert = WorkoutCategory::create($ins);

            if($insert)
            {
                return redirect()->back()->with('success','Workout Category Added Successfully');
            }
        }
    }

    public function edit_workout_category(Request $request)
    {
        $data['workout_category'] = WorkoutCategory::where('workout_category_id',$request->segment(3))->first();

        if(!isset($data['workout_category']))
        {
            return redirect('admin/workout_categories');
        }

        $data['set'] = 'workout_categories';
        return view('admin.workout_category.edit_workout_category',$data);
    }

    public function update_workout_category(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['workout_category_image'=>'nullable|image|mimes:jpeg,jpg,png,gif',
                       'workout_category_name' => 'required'];

            $messages = [
                        'workout_category_name.required'=>'Please enter title'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['workout_category_slug'] = Str::slug($request->workout_category_name);
            $check_name = WorkoutCategory::where($where_name)->where('workout_category_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['workout_category_name']      = $request->workout_category_name;
            $upd['workout_category_slug']       = Str::slug($request->workout_category_name);
            $upd['workout_category_description']     = $request->workout_category_description;
            $upd['workout_category_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $upd['workout_category_updated_on'] = date('Y-m-d H:i:s');

            if($request->hasFile('workout_category_image'))
            {
                $workout_category_image = $request->workout_category_image->store('assets/admin/uploads/workout_category');

                $workout_category_image = explode('/',$workout_category_image);
                $workout_category_image = end($workout_category_image);
                $upd['workout_category_image'] = $workout_category_image;
            }
            if($request->hasFile('workout_category_cover_image'))
            {
                $workout_category_cover_image = $request->workout_category_cover_image->store('assets/admin/uploads/workout_category');

                $workout_category_cover_image = explode('/',$workout_category_cover_image);
                $workout_category_cover_image = end($workout_category_cover_image);
                $upd['workout_category_cover_image'] = $workout_category_cover_image;
            }
            if($request->hasFile('workout_category_feature_image'))
            {
                $workout_category_feature_image = $request->workout_category_feature_image->store('assets/admin/uploads/workout_category');

                $workout_category_feature_image = explode('/',$workout_category_feature_image);
                $workout_category_feature_image = end($workout_category_feature_image);
                $upd['workout_category_feature_image'] = $workout_category_feature_image;
            }

            $update = WorkoutCategory::where('workout_category_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Workout Category Updated Successfully');
            }
        }
    }

    public function workout_category_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['workout_category_status'] = 2;
        }
        else
        {
            $upd['workout_category_status'] = 1;
        }

        $where['workout_category_id'] = $id;

        $update = WorkoutCategory::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

}
