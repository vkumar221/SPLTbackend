<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DataTables;
use DB;
use Helpers;
use Mail;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderComment;
use App\Models\User;
use PDF;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'orders';
        return view('admin.order.orders',$data);
    }

    public function get_orders(Request $request)
    {
        if($request->ajax())
        {
            $data = Order::getDetails(['order_trash'=>0]);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y h:i a',strtotime($row->order_added_on));

                        return $added_on;
                    })
                    ->addColumn('status', function($row){
                        if($row->order_status == 1)
                        {
                            $status = '<span class="status-label text-white">Placed</span>';
                        }
                        elseif($row->order_status == 2)
                        {
                            $status = '<span class="status-label text-white">Processed</span>';
                        }
                        elseif($row->order_status == 3)
                        {
                            $status = '<span class="status-label text-white">Shipped</span>';
                        }
                        elseif($row->order_status == 4)
                        {
                            $status = '<span class="status-label text-white">Delivered</span>';
                        }
                        elseif($row->order_status == 5)
                        {
                            $status = '<span class="status-label text-white">Cancelled</span>';
                        }
                        else
                        {
                            $status = '<span class="status-label text-white">Returned</span>';
                        }
                        return $status;
                    })
                    ->addColumn('pay_status', function($row){
                        if($row->order_pay_status == 1)
                        {
                            $pay_status = '<span class="status-label text-white">Pending</span>';
                        }
                        elseif($row->order_pay_status == 2)
                        {
                            $pay_status = '<span class="status-label text-white">Success</span>';
                        }
                        else
                        {
                            $pay_status = '<span class="status-label text-white">Cancelled</span>';
                        }
                        return $pay_status;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('admin/edit_order/'.$row->order_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        return $btn;
                    })
                    ->rawColumns(['action','status','pay_status'])
                    ->make(true);
        }
    }

    public function edit_order(Request $request)
    {
        $data['order'] = $order = Order::where('order_id',$request->segment(3))->first();
        $data['items'] = OrderItem::getDetails(['order_item_order'=>$request->segment(3)]);
        $data['comments'] = $comments = OrderComment::getDetails(['order_comment_order'=>$request->segment(3)]);
        $data['comment'] = $comments->first();

        if(!isset($data['order']))
        {
            return redirect('admin/orders');
        }
        $data['set'] = 'orders';
        return view('admin.order.edit_order',$data);
    }

    public function update_order_address(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['order_name'=>'required',
                       'order_phone' => 'required',
                       'order_address' => 'required',
                       'order_city' => 'required',
                       'order_state' => 'required',
                       'order_zip' => 'required',];

            $messages = ['order_name.required'=>'Please enter name',
                         'order_phone.required'=>'Please enter phone number',
                         'order_address.required'=>'Please enter address',
                         'order_city.required'=>'Please enter city name',
                         'order_state.required'=>'Please choose state',
                         'order_zip.required'=>'Please enter zipcode',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $order = Order::where('order_id',$request->segment(3))->first();

                $upd['order_name']         = $request->order_name;
                $upd['order_phone']        = $request->order_phone;
                $upd['order_company']      = $request->order_company;
                $upd['order_address']      = $request->order_address;
                $upd['order_address2']     = $request->order_address2;
                $upd['order_city']         = $request->order_city;
                $upd['order_state']        = $request->order_state;
                $upd['order_notes']        = $request->order_notes;
                $upd['order_zip']          = $request->order_zip;
                $upd['order_updated_on']   = date('Y-m-d H:i:s');
                $upd['order_updated_by']   = Auth::guard('admin')->user()->admin_id;

                $update = Order::where('order_id',$request->segment(3))->update($upd);

                if($update)
                {
                    return redirect()->back()->with('success','Order Updated Successfully');
                }
            }
        }
    }

    public function order_status(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['order_status'=>'required',
                       'order_pay_status' => 'required',];

            $messages = ['order_status.required'=>'Please choose status',
                         'order_pay_status.required'=>'Please choose pay status',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $order = Order::where('order_id',$request->segment(3))->first();

                $upd['order_status']        = $request->order_status;
                $upd['order_pay_status']   = $request->order_pay_status;
                $upd['order_updated_on']   = date('Y-m-d H:i:s');
                $upd['order_updated_by']   = Auth::guard('admin')->user()->admin_id;

                $update = Order::where('order_id',$request->segment(3))->update($upd);

                if($update)
                {
                    foreach($request->order_item_id as $item_id)
                    {
                        $item = OrderItem::find($item_id);
                        $item->order_item_status = $request->order_item_status[$item_id];
                        $item->save();

                        if($request->order_comment[$item_id] != NULL)
                        {
                            $ins['order_comment_order']        = $request->segment(3);
                            $ins['order_comment_order_status'] = $request->order_item_status[$item_id];
                            $ins['order_comment_item']         = $item_id;
                            $ins['order_comment_pay_status']   = $request->order_pay_status;
                            $ins['order_comment_text']         = $request->order_comment[$item_id];
                            $ins['order_comment_nofity']       = $request->order_comment_nofity[$item_id];
                            $ins['order_comment_added_on']     = date('Y-m-d H:i:s');
                            $ins['order_comment_added_by']     = Auth::guard('admin')->user()->admin_id;
                            $ins['order_comment_updated_on']   = date('Y-m-d H:i:s');
                            $ins['order_comment_updated_by']   = Auth::guard('admin')->user()->admin_id;

                            $comment =OrderComment::create($ins);
                        }

                    }
                    return redirect()->back()->with('success','Order Status Updated Successfully');
                }
            }
        }
    }

    public function delete_order(Request $request)
    {
        $id = $request->segment(3);

        $where['order_id'] = $id;

        $delete = Order::where($where)->delete();
        $delete_item = DB::table('order_items')->where('order_item_order',$id)->delete();

        if($delete)
        {
            return redirect()->back()->with('success','Order Deleted Successfully');
        }
    }

    public function invoice_download(Request $request)
    {
        $data['order'] = $order = Order::getDetails(['order_id'=>$request->segment(3)])->first();
        $data['items'] = OrderItem::getDetails(['order_item_order'=>$request->segment(3)]);

        $pdf = PDF::loadView('admin.order.invoice_download', $data);

        return $pdf->stream('Invoice_'.$order->order_id.'.pdf');
    }

}
