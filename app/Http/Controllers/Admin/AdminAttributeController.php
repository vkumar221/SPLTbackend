<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Attribute;
use App\Models\AttributeVariation;
use App\Models\Category;

class AdminAttributeController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'attributes';
        $data['attributes'] = Attribute::orderby('attribute_id','asc')->paginate(10);
        return view('admin.attribute.attributes',$data);
    }

    public function get_attributes(Request $request)
    {
        if($request->ajax())
        {
            $data = Attribute::getDetails(['attribute_trash'=>0]);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->attribute_added_on));

                        return $added_on;
                    })
                    ->addColumn('status', function($row)
                    {
                        if($row->attribute_status == 1)
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

                        $btn = '<a href="'.url('admin/edit_attribute/'.$row->attribute_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->attribute_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/attribute_status/'.$row->attribute_id.'/'.$row->attribute_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/attribute_status/'.$row->attribute_id.'/'.$row->attribute_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_attribute(Request $request)
    {
        $data['set'] = 'attributes';
        $data['categories'] = Category::where('category_status',1)->get();
        return view('admin.attribute.add_attribute',$data);
    }

    public function create_attribute(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['attribute_type'=>'required',
                       'attribute_name' => 'required',
                       'attribute_category' => 'required'];

            $messages = ['attribute_type.required'=>'Please Enter type',
                        'attribute_name.required'=>'Please enter name',
                        'attribute_category.required'=>'Please choose category'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['attribute_name'] = $request->attribute_name;
            $check_name = Attribute::where($where_name)->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['attribute_name']       = $request->attribute_name;
            $ins['attribute_type']       = $request->attribute_type;
            $ins['attribute_category']   = $request->attribute_category;
            $ins['attribute_status']     = 1;
            $ins['attribute_added_by']   = Auth::guard('admin')->user()->admin_id;
            $ins['attribute_added_on']   = date('Y-m-d H:i:s');
            $ins['attribute_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $ins['attribute_updated_on'] = date('Y-m-d H:i:s');

            $insert_id = Attribute::insertGetId($ins);
            if(isset($request->attribute_variation_name))
            {
                foreach($request->attribute_variation_name as $key => $variation_name)
                {
                    $ins_var['attribute_variation_name']           = $variation_name;
                    $ins_var['attribute_variation_attribute']      = $insert_id;
                    $ins_var['attribute_variation_value']          = $request->attribute_variation_value[$key];
                    $ins_var['attribute_variation_status']         = 1;
                    $ins_var['attribute_variation_added_by']       = Auth::guard('admin')->user()->admin_id;
                    $ins_var['attribute_variation_added_on']       = date('Y-m-d H:i:s');
                    $ins_var['attribute_variation_updated_by']     = Auth::guard('admin')->user()->admin_id;
                    $ins_var['attribute_variation_updated_on']     = date('Y-m-d H:i:s');

                    $inser_var = AttributeVariation::create($ins_var);
                }
            }

            if($insert_id)
            {
                return redirect()->back()->with('success','Attribute Added Successfully');
            }
        }
    }

    public function edit_attribute(Request $request)
    {
        $data['attribute'] = Attribute::where('attribute_id',$request->segment(3))->first();
        $data['categories'] = Category::where('category_status',1)->get();
        $data['attribute_variations'] = AttributeVariation::where(['attribute_variation_attribute'=>$request->segment(3),'attribute_variation_trash'=>0])->get();

        if(!isset($data['attribute']))
        {
            return redirect('admin/attributes');
        }

        $data['set'] = 'attributes';
        return view('admin.attribute.edit_attribute',$data);
    }

    public function update_attribute(Request $request)
    {
        //print_r(count($request->attribute_variation_name_edit));exit;
        if($request->has('submit'))
        {
           $rules = ['attribute_type'=>'required',
                       'attribute_name' => 'required',
                       'attribute_category' => 'required'];

            $messages = ['attribute_type.required'=>'Please Enter type',
                        'attribute_name.required'=>'Please enter name',
                        'attribute_category.required'=>'Please choose category'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['attribute_name'] = $request->attribute_name;
            $check_name = Attribute::where($where_name)->where('attribute_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['attribute_name']      = $request->attribute_name;
            $upd['attribute_type']       = $request->attribute_type;
            $upd['attribute_category']   = $request->attribute_category;
            $upd['attribute_updated_by'] = Auth::guard('admin')->user()->admin_id;
            $upd['attribute_updated_on'] = date('Y-m-d H:i:s');

            $update = Attribute::where('attribute_id',$request->segment(3))->update($upd);

            if(isset($request->attribute_variation_name))
            {
                foreach($request->attribute_variation_name as $key => $variation_name)
                {
                    $upd_var['attribute_variation_name']           = $variation_name;
                    $upd_var['attribute_variation_value']          = $request->attribute_variation_value[$key];
                    $upd_var['attribute_variation_updated_by']     = Auth::guard('admin')->user()->admin_id;
                    $upd_var['attribute_variation_updated_on']     = date('Y-m-d H:i:s');

                    $update_var = AttributeVariation::where('attribute_variation_id',$key)->update($upd_var);
                }
            }

            if(isset($request->attribute_variation_name_edit))
            {

                foreach($request->attribute_variation_name_edit as $key => $variation_name)
                {
                    $ins_var['attribute_variation_name']           = $variation_name;
                    $ins_var['attribute_variation_attribute']      = $request->segment(3);
                    $ins_var['attribute_variation_value']          = $request->attribute_variation_value_edit[$key];
                    $ins_var['attribute_variation_status']         = 1;
                    $ins_var['attribute_variation_added_by']       = Auth::guard('admin')->user()->admin_id;
                    $ins_var['attribute_variation_added_on']       = date('Y-m-d H:i:s');
                    $ins_var['attribute_variation_updated_by']     = Auth::guard('admin')->user()->admin_id;
                    $ins_var['attribute_variation_updated_on']     = date('Y-m-d H:i:s');

                    $inser_var = AttributeVariation::create($ins_var);
                }
            }

            if($update)
            {
                return redirect()->back()->with('success','Attribute Updated Successfully');
            }
        }
    }

    public function attribute_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['attribute_status'] = 2;
        }
        else
        {
            $upd['attribute_status'] = 1;
        }

        $where['attribute_id'] = $id;

        $update = Attribute::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function attribute_variation_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['attribute_variation_status'] = 2;
        }
        else
        {
            $upd['attribute_variation_status'] = 1;
        }

        $where['attribute_variation_id'] = $id;

        $update = AttributeVariation::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function attribute_variation_delete(Request $request)
    {
        $id = $request->segment(3);

        $upd['attribute_variation_trash'] = 1;

        $where['attribute_variation_id'] = $id;

        $update = AttributeVariation::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Deleted Successfully');
        }
    }

}
