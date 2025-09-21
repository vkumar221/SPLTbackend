@extends('admin.layouts.app')
@section('title','SPLT | Brands')
@section('sub_title','Brands Management')
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
                            <li class="breadcrumb-item"><a href="javascript: void(0)">All Brands</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="table-right-box__info">
                            <div class="search-box">
                            <input type="text" class="form-control" name="search" id="customSearch" placeholder="Search" autocomplete="off">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/search-inp.svg')}}" alt="search">
                            </div>
                            <div class="action-button">
                            <a href="{{url('admin/add_brand')}}" class="btn-link"><i class="ti ti-plus f-16"></i> Add Brand</a>
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
                    <table id="brands-management" class="table table-striped nowrap table-wrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Image</th>
                                <th>Title</th>
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
        var dataTable =	$('#brands-management').DataTable({
        processing: true,
        serverSide: true,
        'ajax': {
                type : 'POST',
                url : "{{ route('admin.get-brands') }}",
                'data': function(data){

                    var token = "{{ csrf_token() }}";
                    data._token = token;
                }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'image'},
            {data: 'brand_name'},
            {data: 'status'},
            {data: 'action',orderable: false, searchable: false}
        ]
    });
     $('#customSearch').on('keyup', function () {
    dataTable.search(this.value).draw();
  });
    }
    );


</script>
@endsection
