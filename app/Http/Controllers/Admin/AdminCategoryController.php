<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'categories';
        $data['categories'] = Category::orderby('category_id','asc')->paginate(10);
        return view('admin.category.categories',$data);
    }

    public function get_categories(Request $request)
    {
        if($request->ajax())
        {
            $data = Category::orderby('category_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->category_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/admin/uploads/category/'.$row->category_image).'" alt="..." class="avatar-img rounded" height="50">';

                        return $image;
                    })
                    ->addColumn('status', function($row)
                    {
                        if($row->category_status == 1)
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

                        $btn = '<a href="'.url('admin/edit_category/'.$row->category_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->category_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/category_status/'.$row->category_id.'/'.$row->category_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/category_status/'.$row->category_id.'/'.$row->category_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_category(Request $request)
    {
        $data['set'] = 'categories';
        return view('admin.category.add_category',$data);
    }

    public function create_category(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['category_image'=>'required|image|mimes:jpeg,jpg,png,gif',
                       'category_name' => 'required'];

            $messages = ['category_image.required'=>'Please choose image',
                        'category_name.required'=>'Please enter name'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['category_slug'] = Str::slug($request->category_name);
            $check_name = Category::where($where_name)->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['category_name']        = $request->category_name;
            $ins['category_slug']        = Str::slug($request->category_name);
            $ins['category_description'] = $request->category_description;
            $ins['category_status']     = 1;
            $ins['category_added_by']   = Auth::guard('admin')->user()->admin_id;
            $ins['category_added_on']   = date('Y-m-d H:i:s');
            $ins['category_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $ins['category_updated_on'] = date('Y-m-d H:i:s');
            if($request->hasFile('category_image'))
            {
                $category_image = $request->category_image->store('assets/admin/uploads/category');

                $category_image = explode('/',$category_image);
                $category_image = end($category_image);
                $ins['category_image'] = $category_image;
            }
            if($request->hasFile('category_cover_image'))
            {
                $category_cover_image = $request->category_cover_image->store('assets/admin/uploads/category');

                $category_cover_image = explode('/',$category_cover_image);
                $category_cover_image = end($category_cover_image);
                $ins['category_cover_image'] = $category_cover_image;
            }
            if($request->hasFile('category_feature_image'))
            {
                $category_feature_image = $request->category_feature_image->store('assets/admin/uploads/category');

                $category_feature_image = explode('/',$category_feature_image);
                $category_feature_image = end($category_feature_image);
                $ins['category_feature_image'] = $category_feature_image;
            }

            $insert = Category::create($ins);

            if($insert)
            {
                return redirect()->back()->with('success','category Added Successfully');
            }
        }
    }

    public function edit_category(Request $request)
    {
        $data['category'] = Category::where('category_id',$request->segment(3))->first();

        if(!isset($data['category']))
        {
            return redirect('admin/categories');
        }

        $data['set'] = 'categories';
        return view('admin.category.edit_category',$data);
    }

    public function update_category(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['category_image'=>'nullable|image|mimes:jpeg,jpg,png,gif',
                       'category_name' => 'required'];

            $messages = [
                        'category_name.required'=>'Please enter title'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['category_slug'] = Str::slug($request->category_name);
            $check_name = Category::where($where_name)->where('category_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['category_name']      = $request->category_name;
            $upd['category_slug']       = Str::slug($request->category_name);
            $upd['category_description']     = $request->category_description;
            $upd['category_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $upd['category_updated_on'] = date('Y-m-d H:i:s');

            if($request->hasFile('category_image'))
            {
                $category_image = $request->category_image->store('assets/admin/uploads/category');

                $category_image = explode('/',$category_image);
                $category_image = end($category_image);
                $upd['category_image'] = $category_image;
            }
            if($request->hasFile('category_cover_image'))
            {
                $category_cover_image = $request->category_cover_image->store('assets/admin/uploads/category');

                $category_cover_image = explode('/',$category_cover_image);
                $category_cover_image = end($category_cover_image);
                $upd['category_cover_image'] = $category_cover_image;
            }
            if($request->hasFile('category_feature_image'))
            {
                $category_feature_image = $request->category_feature_image->store('assets/admin/uploads/category');

                $category_feature_image = explode('/',$category_feature_image);
                $category_feature_image = end($category_feature_image);
                $upd['category_feature_image'] = $category_feature_image;
            }

            $update = Category::where('category_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','category Updated Successfully');
            }
        }
    }

    public function category_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['category_status'] = 2;
        }
        else
        {
            $upd['category_status'] = 1;
        }

        $where['category_id'] = $id;

        $update = Category::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

}
