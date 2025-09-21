<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\PromoCode;

class AdminPromoCodeController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'promo_code';
        return view('admin.promo_codes.promo_codes',$data);
    }

    public function get_promo_codes(Request $request)
    {
        if($request->ajax())
        {
            $data = PromoCode::get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->promo_code_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/admin/uploads/promo_code/'.$row->promo_code_image).'" alt="..." class="avatar-img rounded" width="50">';

                        return $image;
                    })
                     ->addColumn('from', function($row){
                        if($row->promo_code_from != NULL)
                        {
                            $from = date('d-M-y',strtotime($row->promo_code_from));
                        }
                        else
                        {
                            $from = '-';
                        }

                        return $from;
                    })
                    ->addColumn('to', function($row){
                        if($row->promo_code_to != NULL)
                        {
                            $to = date('d-M-y',strtotime($row->promo_code_to));
                        }
                        else
                        {
                            $to = '-';
                        }

                        return $to;
                    })
                     ->addColumn('status', function($row)
                    {
                        if($row->promo_code_status == 1)
                        {
                            $status = '<span class="status-label text-white">Active</span>';
                        }
                        else
                        {
                            $status = '<span class="status-label text-white">Disable</span>';
                        }

                        return $status;

                    })
                    ->addColumn('promo_code_type',function($row)
                    {
                        if($row->promo_code_type == 1)
                        {
                            $promo_code_type = 'Fixed Price';
                        }
                        else
                        {
                            $promo_code_type = 'Percentage';
                        }
                        return $promo_code_type;
                    })

                    ->addColumn('promo_code_duration_type',function($row)
                    {
                        if($row->promo_code_duration_type == 1)
                        {
                            $promo_code_duration_type = 'Limited';
                        }
                        else
                        {
                            $promo_code_duration_type = 'Unlimited';
                        }
                        return $promo_code_duration_type;
                    })

                    ->addColumn('value',function($row)
                    {
                        if($row->promo_code_type == 1)
                        {
                            $value = config('constants.currency_symbol').' '.$row->promo_code_value;
                        }
                        else
                        {
                            $value = $row->promo_code_value.' %';
                        }
                        return $value;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('admin/edit_promo_code/'.$row->promo_code_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->promo_code_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/promo_code_status/'.$row->promo_code_id.'/'.$row->promo_code_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/promo_code_status/'.$row->promo_code_id.'/'.$row->promo_code_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_promo_code(Request $request)
    {
        $data['set'] = 'promo_code';
        return view('admin.promo_codes.add_promo_code',$data);
    }

    public function create_promo_code(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'promo_code_name' => 'required',
                       'promo_code_value' => 'required',
                       'promo_code_from' => 'required',
                       'promo_code_to' => 'required',
                       'promo_code_usage' => 'required',];

            $messages = ['promo_code_name.required'=>'Please enter name',
                        'promo_code_type.required' => 'Please Choose Type',
                        'promo_code_value.required'=>'Please enter price',
                        'promo_code_from.required'=>'Please choose start date',
                        'promo_code_to.required'=>'Please choose end date',
                        'promo_code_usage.required'=>'Please enter usage',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                print_r($validator->errors());exit;
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['promo_code_name'] = $request->promo_code_name;
            $check = PromoCode::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['promo_code_name']               = $request->promo_code_name;
            $ins['promo_code_type']               = $request->promo_code_type;
            $ins['promo_code_value']              = $request->promo_code_value;
            $ins['promo_code_max_order_value']    = $request->promo_code_max_order_value;
            $ins['promo_code_min_order_value']    = $request->promo_code_min_order_value;
            $ins['promo_code_from']               = $request->promo_code_from;
            $ins['promo_code_to']                 = $request->promo_code_to;
            $ins['promo_code_usage']              = $request->promo_code_usage;
            $ins['promo_code_max_users']          = $request->promo_code_max_users;
            $ins['promo_code_status']             = 1;
            $ins['promo_code_added_by']           = Auth::guard('admin')->user()->admin_id;
            $ins['promo_code_added_on']           = date('Y-m-d H:i:s');
            $ins['promo_code_updated_by']         = Auth::guard('admin')->user()->admin_id;
            $ins['promo_code_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('promo_code_image'))
            {
                $promo_code_image = $request->promo_code_image->store('assets/admin/uploads/promo_code');

                $promo_code_image = explode('/',$promo_code_image);
                $promo_code_image = end($promo_code_image);
                $ins['promo_code_image'] = $promo_code_image;
            }

            $insert_id = PromoCode::insertGetId($ins);

            if($insert_id)
            {
                return redirect()->back()->with('success','Promo Code Added Successfully');
            }
        }
    }

    public function edit_promo_code(Request $request)
    {
        $data['promo_code'] = $promo_code = PromoCode::where('promo_code_id',$request->segment(3))->first();

        if(!isset($data['promo_code']))
        {
            return redirect('admin/promo_code');
        }

        $data['set'] = 'promo_code';
        return view('admin.promo_codes.edit_promo_code',$data);
    }

    public function update_promo_code(Request $request)
    {
        $promo_code = PromoCode::where('promo_code_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
            $rules = [ 'promo_code_name' => 'required',
                       'promo_code_value' => 'required',
                       'promo_code_usage' => 'required',];

            $messages = ['promo_code_name.required'=>'Please enter name',
                        'promo_code_type.required' => 'Please Choose Type',
                        'promo_code_value.required'=>'Please enter amount',
                        'promo_code_usage.required'=>'Please enter usage',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['promo_code_name'] = $request->promo_code_name;
            $check_name = PromoCode::where($where)->where('promo_code_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['promo_code_name']               = $request->promo_code_name;
            $upd['promo_code_type']               = $request->promo_code_type;
            $upd['promo_code_value']              = $request->promo_code_value;
            $upd['promo_code_max_order_value']    = $request->promo_code_max_order_value;
            $upd['promo_code_min_order_value']    = $request->promo_code_min_order_value;
            $upd['promo_code_from']               = $request->promo_code_from;
            $upd['promo_code_to']                 = $request->promo_code_to;
            $upd['promo_code_usage']              = $request->promo_code_usage;
            $upd['promo_code_max_users']          = $request->promo_code_max_users;
            $upd['promo_code_updated_by']         = Auth::guard('admin')->user()->admin_id;
            $upd['promo_code_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('promo_code_image'))
            {
                $promo_code_image = $request->promo_code_image->store('assets/admin/uploads/promo_code');

                $promo_code_image = explode('/',$promo_code_image);
                $promo_code_image = end($promo_code_image);
                $upd['promo_code_image'] = $promo_code_image;
            }

            $update = PromoCode::where('promo_code_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Promo Code Updated Successfully');
            }
        }
    }

    public function promo_code_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['promo_code_status'] = 2;
        }
        else
        {
            $upd['promo_code_status'] = 1;
        }

        $where['promo_code_id'] = $id;

        $update = PromoCode::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

}
