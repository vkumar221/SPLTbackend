@extends('vendor.layouts.app')
@section('title','SPLT | Stock & Inventory')
@section('sub_title','Stock & Inventory')
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
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Stock & Inventory</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="table-right-box__info">
                            <div class="filter-box">
                                <select class="form-control" id="product">
                                    <option value="">All Products</option>
                                     @foreach($products as $product)
                                    <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search-box">
                            <input type="text" class="form-control" name="search" id="customSearch" placeholder="Search">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/search-inp.svg')}}" alt="search">
                            </div>
                            <div class="action-button">
                            <a href="{{url('vendor/add_stock')}}" class="btn-link"><i class="ti ti-plus f-16"></i> Add Stock</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row mb-3">
            <div class="col-lg-12 col-md-12">
                <div class="card" style="background-color:transparent;border-color:unset;border: none;">
                <div class="card-body p-0">
                    <div class="table-responsive dt-responsive">
                    <table id="inventory-management" class="table table-striped nowrap table-wrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Variant Name</th>
                                <th>Vendor Name</th>
                                <th>Opening Stock</th>
                                <th>Closing Stock</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>
    $(document).ready(function () {
        var dataTable =	$('#inventory-management').DataTable({
        processing: true,
        serverSide: true,
        'ajax': {
                type : 'POST',
                url : "{{ route('vendor.get-inventory') }}",
                'data': function(data){

                    var token = "{{ csrf_token() }}";
                    var product = $('#product').val();
                    data.product = product;
                    data._token = token;
                }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'image'},
            {data: 'product_name'},
            {data: 'product_variant_name'},
            {data: 'vendor_name'},
            {data: 'inventory_open_stock'},
            {data: 'inventory_close_stock'},
            {data: 'added_on'}
        ]
    });
    $('#customSearch').on('keyup', function () {
    dataTable.search(this.value).draw();
  });
  $('#product').on('change', function () {
    dataTable.draw();
  });
    });

</script>
@endsection
