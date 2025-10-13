@extends('trainer.layouts.app')
@section('title','SPLT | Products')
@section('sub_title','Products Management')
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
                            <li class="breadcrumb-item"><a href="{{url('trainer/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">All Products</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="table-right-box__info">
                            <div class="filter-box">
                                <select class="form-control" id="category">
                                    <option value="">All Categories</option>
                                     @foreach($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search-box">
                            <input type="text" class="form-control" name="search" id="customSearch" placeholder="Search">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/search-inp.svg')}}" alt="search">
                            </div>
                            <div class="action-button">
                            <a href="{{url('trainer/add_product')}}" class="btn-link"><i class="ti ti-plus f-16"></i> Add Product</a>
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
                    <table id="products-management" class="table table-striped nowrap table-wrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Item</th>
                                {{-- <th>Code</th> --}}
                                <th>Category</th>
                                <th>SKU</th>
                                <th>Vendor</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
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
        var dataTable =	$('#products-management').DataTable({
        processing: true,
        serverSide: true,
        'ajax': {
                type : 'POST',
                url : "{{ route('trainer.get-products') }}",
                'data': function(data){

                    var token = "{{ csrf_token() }}";
                    var category = $('#category').val();
                    data.category = category;
                    data._token = token;
                }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'image'},
            {data: 'category_name'},
            {data: 'product_sku'},
            {data: 'vendor_name'},
            {data: 'product_price'},
            {data: 'status'},
            {data: 'action',orderable: false, searchable: false}
        ]
    });
     $('#customSearch').on('keyup', function () {
    dataTable.search(this.value).draw();
  });
     $('#category').on('change', function () {
    dataTable.draw();
  });
    });
</script>
@endsection
