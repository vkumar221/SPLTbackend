<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DataTables;
use DB;
use Helpers;
use Mail;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderComment;
use App\Models\User;
use PDF;

class VendorOrderController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'orders';
        return view('vendor.order.orders',$data);
    }

    public function get_orders(Request $request)
    {
        if($request->ajax())
        {
            $where['order_trash'] = 0;
            $where['product_vendor'] = Auth::guard('vendor')->user()->vendor_id;
            $data = OrderItem::getOrder($where);

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

                        $btn = '<a href="'.url('vendor/edit_order/'.$row->order_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        return $btn;
                    })
                    ->rawColumns(['action','status','pay_status'])
                    ->make(true);
        }
    }

    public function edit_order(Request $request)
    {
        $data['order'] = $order = Order::where('order_id',$request->segment(3))->first();
        $data['items'] = OrderItem::getDetails(['order_item_order'=>$request->segment(3),'product_vendor'=>Auth::guard('vendor')->user()->vendor_id]);
        $data['comments'] = $comments = OrderComment::getDetails(['order_comment_order'=>$request->segment(3),'product_vendor'=>Auth::guard('vendor')->user()->vendor_id]);
        $data['comment'] = $comments->first();

        if(!isset($data['order']))
        {
            return redirect('vendor/orders');
        }
        $data['set'] = 'orders';
        return view('vendor.order.edit_order',$data);
    }

    public function order_status(Request $request)
    {
        if($request->has('submit'))
        {
            $order = Order::where('order_id',$request->segment(3))->first();

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
                    $ins['order_comment_pay_status']   = $order->order_pay_status;
                    $ins['order_comment_text']         = $request->order_comment[$item_id];
                    $ins['order_comment_nofity']       = $request->order_comment_nofity[$item_id];
                    $ins['order_comment_added_on']     = date('Y-m-d H:i:s');
                    $ins['order_comment_added_by']     = Auth::guard('vendor')->user()->vendor_id;
                    $ins['order_comment_updated_on']   = date('Y-m-d H:i:s');
                    $ins['order_comment_updated_by']   = Auth::guard('vendor')->user()->vendor_id;

                    $comment =OrderComment::create($ins);
                }

            }
            return redirect()->back()->with('success','Order Status Updated Successfully');
        }
    }


    public function invoice_download(Request $request)
    {
        $data['order'] = $order = Order::getDetails(['order_id'=>$request->segment(3)])->first();
        $data['items'] = OrderItem::getDetails(['order_item_order'=>$request->segment(3)]);

        $pdf = PDF::loadView('vendor.order.invoice_download', $data);

        return $pdf->stream('Invoice_'.$order->order_id.'.pdf');
    }

}
