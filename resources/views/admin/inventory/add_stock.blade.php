@extends('admin.layouts.app')
@section('title','SPLT | Stock & Inventory')
@section('sub_title','Add Stock')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.inventory')}}">Stock & Inventory</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Stock</a></li>
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
                <form id="add_inventory" action="{{ route('admin.add-inventory') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="form-group">
                        <label for="inventory_name">Vendor</label>
                        <select name="inventory_vendor" id="inventory_vendor" class="form-control" onchange="select_product()">
                            <option value="">Select</option>
                            @foreach($vendors as $vendor)
                            <option value="{{$vendor->vendor_id}}">{{$vendor->vendor_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        @if($errors->has('inventory_vendor'))
                        <p class="text-danger">{{ $errors->first('inventory_vendor') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="form-group">
                        <label for="inventory_name">Product</label>
                        <select name="inventory_product" id="inventory_product" class="form-control" onchange="get_variant()">
                            <option value="">Select</option>
                        </select>
                        </div>
                        @if($errors->has('inventory_product'))
                        <p class="text-danger">{{ $errors->first('inventory_product') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12" id="variant_table">
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.inventory')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

function select_product()
{
    var vendor = $('#inventory_vendor').val();
    var csrf = "{{ csrf_token() }}";
    if(vendor !="")
    {
        $.ajax({
            url:"{{route('admin.select_product')}}",
            type:"post",
            data:'_token='+csrf+'&vendor='+vendor,
            success:function(data){
                $('#inventory_product').html(data);
            }

            });
    }
}

function get_variant()
{
    var product = $('#inventory_product').val();
    var csrf = "{{ csrf_token() }}";
    if(product !="")
    {
        $.ajax({
            url:"{{route('admin.select_variant')}}",
            type:"post",
            data:'_token='+csrf+'&product='+product,
            success:function(data){
                $('#variant_table').html(data);
            }

            });
    }
}
</script>
@endsection
