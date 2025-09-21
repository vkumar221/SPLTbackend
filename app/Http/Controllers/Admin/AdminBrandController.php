<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Brand;

class AdminbrandController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'brands';
        $data['brands'] = Brand::orderby('brand_id','asc')->paginate(10);
        return view('admin.brand.brands',$data);
    }

    public function get_brands(Request $request)
    {
        if($request->ajax())
        {
            $data = Brand::orderby('brand_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->brand_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/admin/uploads/brand/'.$row->brand_image).'" alt="..." class="avatar-img rounded" width="50">';

                        return $image;
                    })
                    ->addColumn('status', function($row)
                    {
                        if($row->brand_status == 1)
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

                        $btn = '<a href="'.url('admin/edit_brand/'.$row->brand_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->brand_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/brand_status/'.$row->brand_id.'/'.$row->brand_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/brand_status/'.$row->brand_id.'/'.$row->brand_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_brand(Request $request)
    {
        $data['set'] = 'brands';
        return view('admin.brand.add_brand',$data);
    }

    public function create_brand(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['brand_image'=>'required|image|mimes:jpeg,jpg,png,gif',
                       'brand_name' => 'required'];

            $messages = ['brand_image.required'=>'Please choose image',
                        'brand_name.required'=>'Please enter name'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['brand_slug'] = Str::slug($request->brand_name);
            $check_name = Brand::where($where_name)->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['brand_name']        = $request->brand_name;
            $ins['brand_slug']        = Str::slug($request->brand_name);
            $ins['brand_description'] = $request->brand_description;
            $ins['brand_category']     = $request->brand_category;
            $ins['brand_status']     = 1;
            $ins['brand_added_by']   = Auth::guard('admin')->user()->admin_id;
            $ins['brand_added_on']   = date('Y-m-d H:i:s');
            $ins['brand_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $ins['brand_updated_on'] = date('Y-m-d H:i:s');
            if($request->hasFile('brand_image'))
            {
                $brand_image = $request->brand_image->store('assets/admin/uploads/brand');

                $brand_image = explode('/',$brand_image);
                $brand_image = end($brand_image);
                $ins['brand_image'] = $brand_image;
            }
            if($request->hasFile('brand_cover_image'))
            {
                $brand_cover_image = $request->brand_cover_image->store('assets/admin/uploads/brand');

                $brand_cover_image = explode('/',$brand_cover_image);
                $brand_cover_image = end($brand_cover_image);
                $ins['brand_cover_image'] = $brand_cover_image;
            }

            $insert = Brand::create($ins);

            if($insert)
            {
                return redirect()->back()->with('success','brand Added Successfully');
            }
        }
    }

    public function edit_brand(Request $request)
    {
        $data['brand'] = Brand::where('brand_id',$request->segment(3))->first();

        if(!isset($data['brand']))
        {
            return redirect('admin/brands');
        }

        $data['set'] = 'brands';
        return view('admin.brand.edit_brand',$data);
    }

    public function update_brand(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['brand_image'=>'nullable|image|mimes:jpeg,jpg,png,gif',
                       'brand_name' => 'required'];

            $messages = [
                        'brand_name.required'=>'Please enter title'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['brand_slug'] = Str::slug($request->brand_name);
            $check_name = Brand::where($where_name)->where('brand_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['brand_name']         = $request->brand_name;
            $upd['brand_slug']         = Str::slug($request->brand_name);
            $upd['brand_description']  = $request->brand_description;
            $upd['brand_category']     = $request->brand_category;
            $upd['brand_updated_by']   = Auth::guard('admin')->user()->admin_id;
            $upd['brand_updated_on']   = date('Y-m-d H:i:s');

            if($request->hasFile('brand_image'))
            {
                $brand_image = $request->brand_image->store('assets/admin/uploads/brand');

                $brand_image = explode('/',$brand_image);
                $brand_image = end($brand_image);
                $upd['brand_image'] = $brand_image;
            }
            if($request->hasFile('brand_cover_image'))
            {
                $brand_cover_image = $request->brand_cover_image->store('assets/admin/uploads/brand');

                $brand_cover_image = explode('/',$brand_cover_image);
                $brand_cover_image = end($brand_cover_image);
                $upd['brand_cover_image'] = $brand_cover_image;
            }

            $update = Brand::where('brand_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Brand Updated Successfully');
            }
        }
    }

    public function brand_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['brand_status'] = 2;
        }
        else
        {
            $upd['brand_status'] = 1;
        }

        $where['brand_id'] = $id;

        $update = Brand::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

}
