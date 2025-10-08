<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use DB;
use App\Models\SubscriptionPlan;

class AdminSubscriptionPlanController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'subscription_plan';
        return view('admin.subscription_plans.subscription_plans',$data);
    }

    public function get_subscription_plans(Request $request)
    {
        if($request->ajax())
        {
            $data = SubscriptionPlan::get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->subscription_plan_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        if($row->subscription_plan_image != NULL)
                        {
                            $image = '<img src="'.url('assets/admin/uploads/subscription_plan/'.$row->subscription_plan_image).'" alt="..." class="avatar-img rounded" width="50">';
                        }
                        else
                        {
                            $image = '<img src="'.url('assets/admin/images/placeholder.png/').'" alt="..." class="avatar-img rounded" width="50">';
                        }

                        return $image;
                    })
                     ->addColumn('status', function($row)
                    {
                        if($row->subscription_plan_status == 1)
                        {
                            $status = '<span class="status-label text-white">Active</span>';
                        }
                        else
                        {
                            $status = '<span class="status-label text-white">Disable</span>';
                        }

                        return $status;

                    })

                    ->addColumn('price',function($row)
                    {
                        $price = config('constants.currency_symbol').' '.$row->subscription_plan_price;

                        return $price;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('admin/edit_subscription_plan/'.$row->subscription_plan_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->subscription_plan_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/subscription_plan_status/'.$row->subscription_plan_id.'/'.$row->subscription_plan_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/subscription_plan_status/'.$row->subscription_plan_id.'/'.$row->subscription_plan_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_subscription_plan(Request $request)
    {
        $data['set'] = 'subscription_plan';
        $data['plan_items'] = DB::table('plan_items')->get();
        return view('admin.subscription_plans.add_subscription_plan',$data);
    }

    public function create_subscription_plan(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'subscription_plan_title' => 'required',
                       'subscription_plan_price' => 'required',
                       'subscription_plan_discount' => 'required',
                       'subscription_plan_description' => 'required',
                       'subscription_plan_popular' => 'required',];

            $messages = ['subscription_plan_title.required'=>'Please enter name',
                        'subscription_plan_discount.required' => 'Please Enter annual Discount',
                        'subscription_plan_price.required'=>'Please enter price',
                        'subscription_plan_description.required'=>'Please enter description',
                        'subscription_plan_popular.required'=>'Please choose it',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['subscription_plan_title'] = $request->subscription_plan_title;
            $check = SubscriptionPlan::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['subscription_plan_title']              = $request->subscription_plan_title;
            $ins['subscription_plan_discount']           = $request->subscription_plan_discount;
            $ins['subscription_plan_price']              = $request->subscription_plan_price;
            $ins['subscription_plan_description']        = $request->subscription_plan_description;
            $ins['subscription_plan_popular']            = $request->subscription_plan_popular;
            $ins['subscription_plan_role']               = 1;
            $ins['subscription_plan_status']             = 1;
            $ins['subscription_plan_added_by']           = Auth::guard('admin')->user()->admin_id;
            $ins['subscription_plan_added_on']           = date('Y-m-d H:i:s');
            $ins['subscription_plan_updated_by']         = Auth::guard('admin')->user()->admin_id;
            $ins['subscription_plan_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('subscription_plan_image'))
            {
                $subscription_plan_image = $request->subscription_plan_image->store('assets/admin/uploads/subscription_plan');

                $subscription_plan_image = explode('/',$subscription_plan_image);
                $subscription_plan_image = end($subscription_plan_image);
                $ins['subscription_plan_image'] = $subscription_plan_image;
            }

            $insert_id = SubscriptionPlan::insertGetId($ins);

            if($insert_id)
            {
                if(isset($request->plan_item))
                {
                    foreach($request->plan_item as $plan_item)
                    {
                        $insp['subscription_plan_item_plan'] = $insert_id;
                        $insp['subscription_plan_item'] = $plan_item;

                        DB::table('subscription_plan_items')->insert($insp);
                    }
                }
                return redirect()->back()->with('success','Subscription Plan Added Successfully');
            }
        }
    }

    public function edit_subscription_plan(Request $request)
    {
        $data['subscription_plan'] = $subscription_plan = SubscriptionPlan::where('subscription_plan_id',$request->segment(3))->first();
        $data['plan_items'] = DB::table('plan_items')->get();
        $subscription_plan_items = DB::table('subscription_plan_items')->where('subscription_plan_item_plan',$request->segment(3))->get();
        $data['sub_plan_items'] = array();
        if($subscription_plan_items->count() > 0)
        {
            foreach($subscription_plan_items as $subscription_plan_item)
            {
                $data['sub_plan_items'][] = $subscription_plan_item->subscription_plan_item;
            }
        }
        if(!isset($data['subscription_plan']))
        {
            return redirect('admin/subscription_plan');
        }

        $data['set'] = 'subscription_plan';
        return view('admin.subscription_plans.edit_subscription_plan',$data);
    }

    public function update_subscription_plan(Request $request)
    {
        $subscription_plan = SubscriptionPlan::where('subscription_plan_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
            $rules = [ 'subscription_plan_title' => 'required',
                       'subscription_plan_price' => 'required',
                       'subscription_plan_discount' => 'required',
                       'subscription_plan_description' => 'required',
                       'subscription_plan_popular' => 'required',];

            $messages = ['subscription_plan_title.required'=>'Please enter name',
                        'subscription_plan_discount.required' => 'Please Enter annual Discount',
                        'subscription_plan_price.required'=>'Please enter price',
                        'subscription_plan_description.required'=>'Please enter description',
                        'subscription_plan_popular.required'=>'Please choose it',];


            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['subscription_plan_title'] = $request->subscription_plan_title;
            $check_name = SubscriptionPlan::where($where)->where('subscription_plan_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['subscription_plan_title']              = $request->subscription_plan_title;
            $upd['subscription_plan_discount']           = $request->subscription_plan_discount;
            $upd['subscription_plan_price']              = $request->subscription_plan_price;
            $upd['subscription_plan_description']        = $request->subscription_plan_description;
            $upd['subscription_plan_popular']            = $request->subscription_plan_popular;
            $upd['subscription_plan_featured']           = $request->subscription_plan_featured;
            $upd['subscription_plan_role']               = $request->subscription_plan_role;
            $upd['subscription_plan_updated_by']         = Auth::guard('admin')->user()->admin_id;
            $upd['subscription_plan_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('subscription_plan_image'))
            {
                $subscription_plan_image = $request->subscription_plan_image->store('assets/admin/uploads/subscription_plan');

                $subscription_plan_image = explode('/',$subscription_plan_image);
                $subscription_plan_image = end($subscription_plan_image);
                $upd['subscription_plan_image'] = $subscription_plan_image;
            }

            $update = SubscriptionPlan::where('subscription_plan_id',$request->segment(3))->update($upd);

            if($update)
            {
                if(isset($request->plan_item))
                {
                    DB::table('subscription_plan_items')->where('subscription_plan_item_plan',$request->segment(3))->delete();

                    foreach($request->plan_item as $plan_item)
                    {
                        $insp['subscription_plan_item_plan'] = $request->segment(3);
                        $insp['subscription_plan_item'] = $plan_item;

                        DB::table('subscription_plan_items')->insert($insp);
                    }
                }
                return redirect()->back()->with('success','Subscription Plan Updated Successfully');
            }
        }
    }

    public function subscription_plan_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['subscription_plan_status'] = 2;
        }
        else
        {
            $upd['subscription_plan_status'] = 1;
        }

        $where['subscription_plan_id'] = $id;

        $update = SubscriptionPlan::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

}
