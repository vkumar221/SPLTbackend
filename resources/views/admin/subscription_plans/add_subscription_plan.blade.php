@extends('admin.layouts.app')
@section('title','SPLT | Subscription Plans')
@section('sub_title','Subscription Plan Management')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.subscription-plans')}}">All Subscription Plans</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Subscription Plan</a></li>
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
                <form id="add_subscription_plan" action="{{ route('admin.add-subscription-plan') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="subscription_plan_title">Plan name</label>
                                <input type="text" class="form-control" name="subscription_plan_title" id="subscription_plan_title" value="{{old('subscription_plan_title')}}" autocomplete="off">
                                 @if($errors->has('subscription_plan_title'))
                                    <p class="text-danger">{{ $errors->first('subscription_plan_title') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="subscription_plan_popular">Popular</label>
                                <select class="form-control" name="subscription_plan_popular" id="subscription_plan_popular">
                                    <option value="1" @if(old('subscription_plan_popular') == 1) selected @endif>No</option>
                                    <option value="2" @if(old('subscription_plan_popular') == 2) selected @endif>Yes</option>
                                </select>
                            </div>
                             @if($errors->has('subscription_plan_popular'))
                                <p class="text-danger">{{ $errors->first('subscription_plan_popular') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="subscription_plan_price">Price</label>
                                <input type="text" class="form-control" name="subscription_plan_price" id="subscription_plan_price" value="{{old('subscription_plan_price')}}" autocomplete="off">
                            </div>
                            @if($errors->has('subscription_plan_price'))
                                <p class="text-danger">{{ $errors->first('subscription_plan_price') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="subscription_plan_discount">Annual Discount</label>
                                <input type="text" class="form-control" name="subscription_plan_discount" id="subscription_plan_discount" value="{{old('subscription_plan_discount')}}" autocomplete="off">
                            </div>
                             @if($errors->has('subscription_plan_discount'))
                                    <p class="text-danger">{{ $errors->first('subscription_plan_discount') }}</p>
                                @endif
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label for="min_amount">Description</label>
                                <textarea class="form-control" name="subscription_plan_description" id="subscription_plan_description" autocomplete="off">{{old('subscription_plan_description')}}</textarea>
                            </div>
                             @if($errors->has('subscription_plan_description'))
                                <p class="text-danger">{{ $errors->first('subscription_plan_description') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label for="subscription_plan_image">Upload Image</label><br>
                                <img id="subscription_plan_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                                <div class="custom-file-wrapper">
                                <span class="file-name"></span>
                                <button type="button" class="browse-btn">Browse</button>
                                <input type="file" name="subscription_plan_image" id="subscription_plan_image" class="custom-file-input">
                                </div>
                            </div>
                            @if($errors->has('subscription_plan_image'))
                                <p class="text-danger">{{ $errors->first('subscription_plan_image') }}</p>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th scope="col">Plan Inclusions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($plan_items as $key => $item)
                                <tr class="checked-row">
                                    <td>
                                    <div class="form-check">
                                        <input class="form-check-input input-info" type="checkbox" id="check_{{$key}}" name="plan_item[{{$item->plan_item_id}}]" value="{{$item->plan_item_id}}">
                                        <label for="check_{{$key}}" class="form-check-label">{{$item->plan_item_name}}</label>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-action__button">
                            <a href="{{route('admin.subscription-plans')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

 subscription_plan_image.onchange = evt => {
  const [file] = subscription_plan_image.files
  if (file) {
    subscription_plan_image_src.src = URL.createObjectURL(file)
  }
 }

</script>
@endsection
