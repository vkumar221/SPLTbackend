@extends('vendor.layouts.app')
@section('title','SPLT | Order')
@section('sub_title','Order Management')
@section('import_export')
<li class="pc-h-item">
    <a href="#" class="pc-head-btn me-3">
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/export-icon.svg')}}" alt="export-icon.svg"></span>
        <span>Export</span>
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/chevron-down.svg')}}" alt="chevron-down.svg"></span>
    </a>
</li>
<li class="pc-h-item">
    <a href="#" class="pc-head-btn me-3">
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/import-icon.svg')}}" alt="import-icon.svg"></span>
        <span>Import</span>
        <span><img src="{{ asset(config('constants.admin_path').'images/icons/chevron-down.svg')}}" alt="chevron-down.svg"></span>
    </a>
</li>
@endsection
@section('contents')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('vendor/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{url('vendor/orders')}}">All Orders</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Order</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="order-form__wrapper">
                <div class="order-head__box">
                    <div class="order-title">
                        <img src="{{ asset(config('constants.admin_path').'images/icons/flag.svg')}}" alt="flag">
                        <h3>Orders #{{$order->order_refid}}</h3>
                    </div>
                    <div class="order-info__button">
                        {{-- <button class="info-btn-link">Issue refund</button>
                        <button class="info-btn-link">Cancel Order</button> --}}
                        {{-- <button class="info-btn-link">Send Notification</button>
                        <button class="info-btn-link"><img src="{{ asset(config('constants.admin_path').'images/icons/download.svg')}}" alt="download"> Download Invoice</button> --}}
                    </div>
                </div>
                <div class="order-summary__box">
                    <h2>Order Summary</h2>
                    <div class="order-details">
                        <div class="order-column">
                            <div class="order-item">
                            <p>Order ID:</p>
                            <span>#{{$order->order_refid}}</span>
                            </div>
                            <div class="order-item">
                            <p>Customer:</p>
                            <span>{{$order->order_name}}</span>
                            </div>
                            <div class="order-item">
                            <p>Date Added:</p>
                            <span>{{ date('d-m-Y h:i a',strtotime($order->order_added_on))}}</span>
                            </div>
                            <div class="order-item">
                            <p>Shipping Method:</p>
                            <span>Flat Shipping Rate</span>
                            </div>
                        </div>
                        <div class="order-column">
                            <div class="order-item">
                            <p>Order Status:</p>
                            <span>@if($order->order_status == 1) Placed @elseif($order->order_status == 2) Processed @elseif($order->order_status == 3) Shipped @elseif($order->order_status == 4) Delivered @elseif($order->order_status == 5) Cancelled @else Returned @endif</span>
                            </div>
                            <div class="order-item">
                            <p>E-Mail:</p>
                            <span>{{$order->order_email}}</span>
                            </div>
                            <div class="order-item">
                            <p>Original Order Total:</p>
                            <span>{{config('constants.currency_symbol')}} {{$order->order_total}}</span>
                            </div>
                            <div class="order-item">
                            <p>Payment Method:</p>
                            <span>@if($order->order_payment == 1) Stripe @elseif($order->order_payment == 2) Google Pay @else Apple Pay @endif</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="edit-order__box">
                    <h2>Edit Order Details</h2>
                    <div class="order-grid">
                        <div class="row-item"><label>Order ID:</label><span>{{$order->order_refid}}</span></div>
                        <div class="row-item"><label>Customer:</label><span>{{$order->order_name}}</span></div>
                        <div class="row-item"><label>Date Added:</label><span>{{ date('d-m-Y h:i a',strtotime($order->order_added_on))}}</span></div>
                        <div class="row-item"><label>E-Mail:</label><span><input type="email" value="{{$order->order_email}}" readonly></span></div>
                        <div class="row-item"><label>Shipping Method:</label><span>NA</span></div>
                        <div class="row-item"><label>Telephone:</label><span><input type="text" value="{{$order->order_phone}}" readonly></span></div>
                        <div class="row-item"><label>Payment Method:</label><span>@if($order->order_payment == 1) Stripe @elseif($order->order_payment == 2) Google Pay @else Apple Pay @endif</span></div>
                        <div class="row-item"><label>IP Address:</label><span>{{$order->order_ip}}</span></div>
                        <div class="row-item"><label>Order Status:</label><span>@if($order->order_status == 1) Placed @elseif($order->order_status == 2) Processed @elseif($order->order_status == 3) Shipped @elseif($order->order_status == 4) Delivered @elseif($order->order_status == 5) Cancelled @else Returned @endif</span></div>
                        <div class="row-item"><label>Invoice ID:</label><span><button class="btn-generate">Generate</button></span></div>
                        <div class="row-item total-row">
                        <label>Original Order Total:</label>
                        <span>{{config('constants.currency_symbol')}} {{$order->order_total}}</span>
                        </div>
                    </div>
                    @if($order->order_notes != NULL)
                    <div class="comment-text">
                        <p>Comment: <span>{{$order->order_notes}}</span></p>
                    </div>
                    @endif
                </div>
                <div class="order-container">
                    <h2>Edit Order Details</h2>
                    <div class="order-details__box">
                    <div class="order-table">
                    <div class="table-head">
                        <div>Product</div>
                        <div>Quantity</div>
                        <div>Unit Price</div>
                        <div>Total</div>
                    </div>
                    @foreach($items as $item)
                    @php
                        $price[] = $item->order_item_quantity * $item->order_item_price;
                    @endphp
                    <div class="table-row">
                        <div class="table-data">
                        <div class="product-title">{{$item->product_name}}</div>
                        @if($item->order_item_variant != 0)
                        <div class="product-sub">- {{$item->product_variant_name}}</div>
                        @endif
                         <div class="product-sub">Seller: {{$item->vendor_name}}</div>
                        </div>
                        <div class="table-data">
                        {{$item->order_item_quantity}}
                        </div>
                        <div class="table-data">
                        {{config('constants.currency_symbol')}} {{$item->order_item_price}}
                        </div>
                        <div class="table-data">
                        {{config('constants.currency_symbol')}} {{$item->order_item_quantity * $item->order_item_price}}
                        </div>
                    </div>
                    @endforeach
                    </div>
                    <div class="order-summary">
                    <div class="summary-title_head">
                        <div></div>
                        @if($order->order_coupon_code != NULL)
                        <div>Promo Code Applied - "{{$order->order_coupon_code}}" (@if($order->order_discount_per != 0) {{$order->order_discount_per}}% @else {{config('constants.currency_symbol')}} {{$order->order_discount}} @endif) </div>
                        @endif
                        {{-- <div>Retail 8.5%:</div> --}}
                        <div></div>
                    </div>
                    <div class="summary-row">
                        <div class="summary-data">
                            <div class="summary-label">
                            Sub–Total:
                            </div>
                            <div class="summary-value">
                            {{config('constants.currency_symbol')}} {{array_sum($price)}}
                            </div>
                        </div>
                        @if($order->order_coupon_code != NULL)
                        <div class="summary-data">
                            <div class="summary-label">
                                Discount:
                            </div>
                            <div class="summary-value">
                            {{config('constants.currency_symbol')}} {{$order->order_discount}}
                            </div>
                        </div>
                        @endif
                        <div class="summary-data">
                            {{-- <div class="remove-icon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/remove.svg')}}" alt="remove.svg">
                            </div>
                            <div class="summary-value">$2.47</div> --}}
                        </div>
                        <div class="summary-data">
                            <div class="summary-label">
                            Total:
                            </div>
                            <div class="summary-value">
                            {{config('constants.currency_symbol')}} {{array_sum($price)}}
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="status-comments">
                    <h2>Status & Comments</h2>
                     @if($comments->count() > 0)
                    <div class="comments-info__box">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <th width="5%">Sno</th>
                                    <th width="10%">Product</th>
                                    <th width="55%">Comment</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Customer Notified</th>
                                    <th width="10%">Date Added</th>
                                </thead>
                                <tbody>
                                    @foreach($comments as $key => $comment)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{$comment->product_name}}<br>{{$comment->product_variant_name}}</td>
                                        <td>{{$comment->order_comment_text}}</td>
                                        <td>
                                            @if($comment->order_comment_order_status == 1) Placed @elseif($comment->order_comment_order_status == 2) Processed @elseif($comment->order_comment_order_status == 3) Shipped @elseif($comment->order_comment_order_status == 4) Delivered @elseif($comment->order_comment_order_status == 5) Cancelled @else Returned @endif
                                        </td>
                                        <td>@if($comment->order_comment_nofity == 2) Yes @else No @endif</td>
                                        <td>{{date('d-m-Y h:i a',strtotime($comment->order_comment_added_on))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    <div class="comments__form">
                        <h2>Add Status & Comments</h2>
                        <form id="update_status" method="post" action="{{route('vendor.update-order-status',['id'=>$order->order_id])}}">
                        @csrf
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <th width="10%">Image</th>
                                    <th width="10%">Product Variant</th>
                                    <th width="20%">Order Status</th>
                                    <th width="10%">Notify User</th>
                                    <th width="50%">Comment</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $key => $item)
                                    <tr>
                                        <input type="hidden" name="order_item_id[{{$item->order_item_id}}]" value="{{$item->order_item_id}}" >
                                        <td>
                                            <img src="{{ asset(config('constants.vendor_path').'uploads/product/'.$item->product_variant_image) }}" id="imagePreview{{$key}}" class="img-fluid d-flex mx-auto my-4 rounded" alt="Product img" width="68" >
                                        </td>
                                        <td>{{$item->product_name}}<br>{{$item->product_variant_name}}</td>
                                        <td>
                                            <select name="order_item_status[{{$item->order_item_id}}]" id="order_item_status{{$item->order_item_id}}" class="form-control">
                                            <option value="1" @if($item->order_item_status == 1) selected @endif>Placed</option>
                                            <option value="2" @if($item->order_item_status == 2) selected @endif>Processed</option>
                                            <option value="3" @if($item->order_item_status == 3) selected @endif>Shipped</option>
                                            <option value="4" @if($item->order_item_status == 4) selected @endif>Delivered</option>
                                            <option value="5" @if($item->order_item_status == 5) selected @endif>Cancelled</option>
                                        </select>
                                        </td>
                                        <td><select name="order_comment_nofity[{{$item->order_item_id}}]" id="order_comment_nofity{{$item->order_item_id}}" class="form-control">
                                            <option value="1">No</option>
                                            <option value="2">Yes</option>
                                            </select>
                                        </td>
                                        <td><textarea rows="3" class="form-control" name="order_comment[{{$item->order_item_id}}]" id="order_comment{{$item->order_item_id}}"></textarea></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-action__button justify-content-end mt-3" style="margin:0 20px">
                    <a href="{{url('vendor/orders')}}" class="btn-link btn-white"><img style="margin-right:5px;" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
                    <button type="submit" class="btn-link btn-dark" style="color:white;" name="submit" value="submit">Submit</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')

@endsection
