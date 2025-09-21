@extends('admin.layouts.app')
@section('title','SPLT | Promo Code')
@section('sub_title','Promo Code Management')
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
                            <li class="breadcrumb-item"><a href="javascript: void(0)">All Promo Code</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="table-right-box__info">
                            <div class="search-box">
                            <input type="text" class="form-control" name="search" id="customSearch" placeholder="Search" autocomplete="off">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/search-inp.svg')}}" alt="search">
                            </div>
                            <div class="action-button">
                            <a href="{{url('admin/add_promo_code')}}" class="btn-link"><i class="ti ti-plus f-16"></i> Add Promo Code</a>
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
                    <table id="promo-code-management" class="table table-striped nowrap table-wrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Amount</th>
                                <th>Discount type</th>
                                <th>End Date</th>
                                <th>No. of Users</th>
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
        var dataTable =	$('#promo-code-management').DataTable({
        processing: true,
        serverSide: true,
        'ajax': {
                type : 'POST',
                url : "{{ route('admin.get-promo-codes') }}",
                'data': function(data){

                    var token = "{{ csrf_token() }}";
                    data._token = token;
                }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'image'},
            {data: 'promo_code_name'},
            {data: 'promo_code_value'},
            {data: 'promo_code_type'},
            {data: 'promo_code_to'},
            {data: 'promo_code_max_users'},
            {data: 'status'},
            {data: 'action',orderable: false, searchable: false}
        ]
    });
    $('#customSearch').on('keyup', function () {
    dataTable.search(this.value).draw();
  });
    });
</script>
@endsection
