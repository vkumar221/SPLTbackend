@extends('admin.layouts.app')
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
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{url('admin/orders')}}">All Orders</a></li>
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
                            <span>@if($order->order_status == 1) Placed @elseif($order->order_status == 2) Confirmed @elseif($order->order_status == 3) Shipped @elseif($order->order_status == 4) Delivered @elseif($order->order_status == 5) Cancelled @else Returned @endif</span>
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
                        <div class="row-item"><label>Order Status:</label><span>@if($order->order_status == 1) Placed @elseif($order->order_status == 2) Confirmed @elseif($order->order_status == 3) Shipped @elseif($order->order_status == 4) Delivered @elseif($order->order_status == 5) Cancelled @else Returned @endif</span></div>
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
                            <div class="summary-value">$2.00</div> --}}
                        </div>
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
                            {{config('constants.currency_symbol')}} {{array_sum($price) - $order->order_discount}}
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="shipping-address">
                    <h2>Edit Shipping Address</h2>
                    <div class="shipping-address__form">
                        <form id="order_address" method="post" action="{{route('admin.update-order-address',['id'=>$order->order_id])}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label>Full Name :</label>
                                <input type="text" class="form-control" id="order_name" value="{{$order->order_name}}" name="order_name" autocomplete="off">
                                @if($errors->has('order_name'))
                                <p class="text-danger">{{ $errors->first('order_name') }}</p>
                                @endif
                                </div>
                                <div class="form-group">
                                <label>Address 1 :</label>
                                <input type="text" class="form-control" id="order_address" value="{{$order->order_address}}" name="order_address" autocomplete="off">
                                @if($errors->has('order_address'))
                                <p class="text-danger">{{ $errors->first('order_address') }}</p>
                                @endif
                                </div>
                                <div class="form-group">
                                <label>Address 2 :</label>
                                <input type="text" class="form-control" id="order_address2" value="{{$order->order_address2}}" name="order_address2" autocomplete="off">
                                @if($errors->has('order_address2'))
                                <p class="text-danger">{{ $errors->first('order_address2') }}</p>
                                @endif
                                </div>
                                <div class="form-group">
                                <label>City :</label>
                                <input type="text" class="form-control" id="order_city" value="{{$order->order_city}}" name="order_city" autocomplete="off">
                                @if($errors->has('order_city'))
                                <p class="text-danger">{{ $errors->first('order_city') }}</p>
                                @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group justify-end w-130">
                                <label>Company :</label>
                                <input type="text" class="form-control" id="order_company" value="{{$order->order_company}}" name="order_company" autocomplete="off">
                                @if($errors->has('order_company'))
                                <p class="text-danger">{{ $errors->first('order_company') }}</p>
                                @endif
                                </div>
                                <div class="form-group justify-end w-130">
                                <label>Mobile Number :</label>
                                <input type="text" class="form-control" id="mobile_no" value="{{$order->order_phone}}" name="order_phone" autocomplete="off">
                                @if($errors->has('order_phone'))
                                <p class="text-danger">{{ $errors->first('order_phone') }}</p>
                                @endif
                                </div>
                                <div class="form-group justify-end w-130">
                                <label>Region / State :</label>
                                <input type="text" class="form-control" id="state" value="{{$order->order_state}}" name="order_state" autocomplete="off">
                                @if($errors->has('order_state'))
                                <p class="text-danger">{{ $errors->first('order_state') }}</p>
                                @endif
                                </div>
                                <div class="form-group justify-end w-130">
                                <label>Zip / Postal code :</label>
                                <input type="text" class="form-control" id="zipcode" value="{{$order->order_zip}}" name="order_zip" autocomplete="off">
                                @if($errors->has('order_zip'))
                                <p class="text-danger">{{ $errors->first('order_zip') }}</p>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-action__button justify-content-end mt-3" style="margin:0 20px">
                            <button type="submit" class="btn btn-primary" name="submit" value="submit">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="status-comments">
                      @if($comments->count() > 0)
                      <h2>Status & Comments</h2>
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
                                            @if($comment->order_comment_order_status == 1) Placed @elseif($comment->order_comment_order_status == 2) Confirmed @elseif($comment->order_comment_order_status == 3) Shipped @elseif($comment->order_comment_order_status == 4) Delivered @elseif($comment->order_comment_order_status == 5) Cancelled @else Returned @endif
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
                        <form id="update_status" method="post" action="{{route('admin.update-order-status',['id'=>$order->order_id])}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-2 col-12">
                                <label>Order Status:</label>
                            </div>
                            <div class="col-lg-10 col-12 mb-3">
                                <select name="order_status" id="order_status" class="form-control">
                                    <option value="1" @if($order->order_status == 1) selected @endif>Placed</option>
                                    <option value="2" @if($order->order_status == 2) selected @endif>Confirmed</option>
                                    <option value="3" @if($order->order_status == 3) selected @endif>Shipped</option>
                                    <option value="4" @if($order->order_status == 4) selected @endif>Delivered</option>
                                    <option value="5" @if($order->order_status == 5) selected @endif>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-12">
                                <label>Payment Status:</label>
                            </div>
                            <div class="col-lg-10 col-12 mb-3">
                                <select name="order_pay_status" id="order_pay_status" class="form-control">
                                <option value="1" @if($order->order_pay_status == 1) selected @endif>Pending</option>
                                <option value="2" @if($order->order_pay_status == 2) selected @endif>Success</option>
                                <option value="3" @if($order->order_pay_status == 3) selected @endif>Failed</option>
                                </select>
                            </div>
                            {{-- <div class="col-lg-2 col-12">
                                <label>Notify Customer:</label>
                            </div>
                            <div class="col-lg-10 col-12 mb-3">
                            <div class="toggle">
                                <div class="toggle-part on-part">
                                <span class="text">ON</span>
                                <span class="circle"></span>
                                </div>
                                <div class="toggle-part off-part active">
                                <span class="text">OFF</span>
                                <span class="circle"></span>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-2 col-12">
                                <label>Append Comments:</label>
                            </div>
                            <div class="col-lg-10 col-12 mb-3">
                                <div class="toggle">
                                    <div class="toggle-part on-part active">
                                    <span class="text">ON</span>
                                    <span class="circle"></span>
                                    </div>
                                    <div class="toggle-part off-part">
                                    <span class="text">OFF</span>
                                    <span class="circle"></span>
                                    </div>
                                </div>
                            </div>
                            --}}
                            {{-- <div class="col-lg-2 col-12">
                                <label>Comment:</label>
                            </div>
                            <div class="col-lg-10 col-12 mb-3">
                                <textarea rows="3" class="form-control" name="order_comment" id="order_comment"></textarea>
                            </div> --}}
                        </div>
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
                                            <option value="2" @if($item->order_item_status == 2) selected @endif>Confirmed</option>
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
                    <a href="{{url('admin/orders')}}" class="btn-link btn-white"><img style="margin-right:5px;" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
