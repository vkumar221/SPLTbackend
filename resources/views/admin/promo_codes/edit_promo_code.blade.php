@extends('admin.layouts.app')
@section('title','SPLT | Promo Codes')
@section('sub_title','Promo Code Management')
@section('import_export')
<li class="pc-h-item">

</li>
<li class="pc-h-item">

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
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{route('admin.promo-codes')}}">All Promo Codes</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Promo Code</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="form-wrapper">
                <form id="edit_promo_code" action="{{ route('admin.edit-promo-code',['id'=>$promo_code->promo_code_id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="promo_code_name">Coupon Code</label>
                                <input type="text" class="form-control" name="promo_code_name" id="promo_code_name" value="{{$promo_code->promo_code_name}}" autocomplete="off">
                                 @if($errors->has('promo_code_name'))
                                    <p class="text-danger">{{ $errors->first('promo_code_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="promo_code_type">Discount Type</label>
                                <select class="form-control" name="promo_code_type" id="promo_code_type">
                                    <option value="1" @if($promo_code->promo_code_type == 1) selected @endif>Fixed Amount</option>
                                    <option value="2" @if($promo_code->promo_code_type == 2) selected @endif>Percentange</option>
                                </select>
                            </div>
                             @if($errors->has('promo_code_name'))
                                <p class="text-danger">{{ $errors->first('promo_code_type') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="promo_code_value">Discount Value</label>
                                <input type="text" class="form-control" name="promo_code_value" id="promo_code_value" value="{{ $promo_code->promo_code_value }}" autocomplete="off">
                            </div>
                            @if($errors->has('promo_code_value'))
                                <p class="text-danger">{{ $errors->first('promo_code_value') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="promo_code_max_order_value">Max Order Amount</label>
                                <input type="text" class="form-control" name="promo_code_max_order_value" id="promo_code_max_order_value" value="{{$promo_code->promo_code_max_order_value}}" autocomplete="off">
                            </div>
                             @if($errors->has('promo_code_max_order_value'))
                                    <p class="text-danger">{{ $errors->first('promo_code_max_order_value') }}</p>
                                @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="min_amount">Min Order Amount</label>
                                <input type="text" class="form-control" name="promo_code_min_order_value" id="promo_code_min_order_value" value="{{$promo_code->promo_code_min_order_value}}" autocomplete="off">
                            </div>
                             @if($errors->has('promo_code_min_order_value'))
                                <p class="text-danger">{{ $errors->first('promo_code_min_order_value') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="promo_code_from">Start Date</label>
                                <input type="date" class="form-control" name="promo_code_from" id="promo_code_from" value="{{$promo_code->promo_code_from}}" autocomplete="off">
                            </div>
                             @if($errors->has('promo_code_from'))
                                <p class="text-danger">{{ $errors->first('promo_code_from') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="promo_code_to" id="promo_code_to" value="{{$promo_code->promo_code_to}}" autocomplete="off">
                            </div>
                            @if($errors->has('promo_code_to'))
                                <p class="text-danger">{{ $errors->first('promo_code_to') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="repeat_usage">Repeat Usage</label>
                                <input type="number" class="form-control" name="promo_code_usage" id="promo_code_usage" value="{{$promo_code->promo_code_usage}}" autocomplete="off">
                            </div>
                            @if($errors->has('promo_code_usage'))
                                <p class="text-danger">{{ $errors->first('promo_code_usage') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="max_users">Max No. Of Users</label>
                                <input type="number" class="form-control" name="promo_code_max_users" id="promo_code_max_users" value="{{$promo_code->promo_code_max_users}}" autocomplete="off">
                            </div>
                            @if($errors->has('promo_code_max_users'))
                                <p class="text-danger">{{ $errors->first('promo_code_max_users') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label for="promo_code_image">Upload Image</label><br>
                                @if($promo_code->promo_code_image != NULL)
                                <img class="mb-2" id="promo_code_image_src" src="{{ asset(config('constants.admin_path').'uploads/promo_code/'.$promo_code->promo_code_image)}}" alt="placeholder" width="68">
                                @else
                                <img id="promo_code_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="100">
                                @endif
                                <div class="custom-file-wrapper">
                                <span class="file-name"></span>
                                <button type="button" class="browse-btn">Browse</button>
                                <input type="file" name="promo_code_image" id="promo_code_image" class="custom-file-input">
                                </div>
                            </div>
                            @if($errors->has('promo_code_image'))
                                <p class="text-danger">{{ $errors->first('promo_code_image') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-action__button">
                            <a href="{{route('admin.promo-codes')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
                            <button type="submit" class="btn-link btn-dark" style="color:white" name="submit" value="Submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>

 promo_code_image.onchange = evt => {
  const [file] = promo_code_image.files
  if (file) {
    promo_code_image_src.src = URL.createObjectURL(file)
  }
 }

</script>
@endsection
