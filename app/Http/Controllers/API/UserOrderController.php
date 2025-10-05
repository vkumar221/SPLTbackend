<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderComment;
use App\Models\OrderRequest;
use App\Models\ProductReview;

class UserOrderController extends BaseController
{
    public function index(Request $request)
    {
        $orders = OrderItem::getOrder(['order_added_by'=>Auth::user()->id]);

        if($orders->count() > 0)
        {
            foreach($orders as $key=> $order)
            {
                $ord[$key]['order_item_id'] = $order->order_item_id;
                $ord[$key]['product_name'] = $order->product_name;
                $ord[$key]['variant_name'] = $order->product_variant_name;
                $ord[$key]['product_image'] = asset(config('constants.admin_path').'uploads/product/'.$order->product_variant_image);
                $ord[$key]['price'] = config('constants.currency_symbol').' '.$order->order_item_price;
            }
            $result['orders'] = $ord;
            return $this->sendResponse($result,'Order item List.');
        }
        else
        {
            return $this->sendError("No Orders found", []);
        }

    }

    public function order_details(Request $request)
    {
        if($request->has('order_item_id'))
        {
            $order = OrderItem::getOrder(['order_added_by'=>Auth::user()->id,'order_item_id'=>$request->order_item_id])->first();
            $order_comments = OrderComment::where(['order_comment_item'=>$request->order_item_id])->get();

            if(isset($order))
            {
                $ord['order_item_id'] = $order->order_item_id;
                $ord['product_name'] = $order->product_name;
                $ord['variant_name'] = $order->product_variant_name;
                $ord['product_image'] = asset(config('constants.admin_path').'uploads/product/'.$order->product_variant_image);
                $ord['price'] = config('constants.currency_symbol').' '.$order->order_item_price;

                if($order_comments->count() > 0)
                {
                    foreach($order_comments as $key =>$comment)
                    {
                        if($comment->order_comment_order_status == 1)
                        {
                            $status = 'Placed';
                        }
                        elseif($comment->order_comment_order_status == 2)
                        {
                            $status = 'Confirmed';
                        }
                        elseif($comment->order_comment_order_status == 3)
                        {
                            $status = 'Shipped';
                        }
                        elseif($comment->order_comment_order_status == 4)
                        {
                            $status = 'Delivered';
                        }
                        elseif($comment->order_comment_order_status == 5)
                        {
                            $status = 'Cancelled';
                        }
                        else
                        {
                            $status = 'Returned';
                        }

                        $ord['comments'][$key]['order_status'] =  $status;
                        $ord['comments'][$key]['comment'] = $comment->order_comment_text;
                        $ord['comments'][$key]['date'] = date('d-M-y h:s A',$comment->order_comment_updated_by);
                    }
                }
                else
                {
                    $ord['comments'] = [];
                }

                $result['order'] = $ord;
                return $this->sendResponse($result,'Order item Details.');
            }
            else
            {
                return $this->sendError("No Order item not found", []);
            }
        }
        else
        {
            return $this->sendError('Please provide order item Id', []);
        }

    }

    public function order_cancel(Request $request)
    {
        $rules = ['order_item_id' => 'required|numeric',
                  'reason' => 'required',
                    ];

        $messages = ['order_item_id.required'=>'Please provide order item id',
                    'reason.required'=>'Please provide reason',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $order = OrderItem::getOrder(['order_added_by'=>Auth::user()->id,'order_item_id'=>$request->order_item_id])->first();

        if(isset($order))

        $ins['order_request_order'] = $order->order_id;
        $ins['order_request_item'] = $request->order_item_id;
        $ins['order_request_comment'] = $request->reason;
        $ins['order_request_added_on'] = date('Y-m-d H:i:s');
        $ins['order_request_added_by'] = Auth::user()->id;
        $ins['order_request_updated_on'] = date('Y-m-d H:i:s');
        $ins['order_request_updated_by'] = Auth::user()->id;

        $insert = OrderRequest::create($ins);

        if($insert)
        {
            return $this->sendResponse([],'Your cancellation request is received.');
        }

    }

    public function order_review(Request $request)
    {
        $rules = ['order_item_id' => 'required|numeric',
                  'rating' => 'required|numeric',
                    ];

        $messages = ['order_item_id.required'=>'Please provide order item id',
                     'rating.required'=>'Please provide rating',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $order = OrderItem::getOrder(['order_added_by'=>Auth::user()->id,'order_item_id'=>$request->order_item_id])->first();

        if(isset($order))

        $ins['product_review_order']      = $order->order_id;
        $ins['product_review_item']       = $request->order_item_id;
        $ins['product_review_rating']     = $request->rating;
        $ins['product_review_comment']    = $request->review;
        $ins['product_review_added_on']   = date('Y-m-d H:i:s');
        $ins['product_review_added_by']   = Auth::user()->id;
        $ins['product_review_updated_on'] = date('Y-m-d H:i:s');
        $ins['product_review_updated_by'] = Auth::user()->id;

        $insert = ProductReview::create($ins);

        if($insert)
        {
            return $this->sendResponse([],'Thanks for your feedback.');
        }

    }

}
