@extends('admin.layouts.app')
@section('title','SPLT | Equipment')
@section('sub_title','Equipment')
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
                            <li class="breadcrumb-item"><a href="javascript: void(0)">All Equipment</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="table-right-box__info">
                            <div class="search-box">
                            <input type="text" class="form-control" name="search" id="customSearch" placeholder="Search" autocomplete="off">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/search-inp.svg')}}" alt="search">
                            </div>
                            <div class="action-button">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_equipment_modal" class="btn-link"><i class="ti ti-plus f-16"></i> Add Equipment</a>
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
                    <table id="equipments" class="table table-striped nowrap table-wrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
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
<div class="modal fade" id="add_equipment_modal" tabindex="-1" aria-labelledby="add_equipment_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="excerciselModalLabel">Add Equipment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="add_equipment" action="{{ route('admin.add-equipment') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="equipment_name" class="form-control" value="{{ old('equipment_name') }}" autocomplete="off">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-submit" name="submit" value="submit">Submit</button>
            </div>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" id="edit_equipment_modal" tabindex="-1" aria-labelledby="edit_equipment_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Equipment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="edit_equipment" action="{{ route('admin.edit-equipment') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="form-group">
                <label for="Name">Name</label>
                <input type="hidden" name="equipment_id" id="equipment_id">
                <input type="text" name="equipment_name" id="equipment_name" class="form-control" value="{{ old('equipment_name') }}" autocomplete="off">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-submit" name="submit" value="submit">Submit</button>
            </div>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>
    $(document).ready(function () {
        var dataTable =	$('#equipments').DataTable({
        processing: true,
        serverSide: true,
        'ajax': {
                type : 'POST',
                url : "{{ route('admin.get-equipments') }}",
                'data': function(data){

                    var token = "{{ csrf_token() }}";
                    data._token = token;
                }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'equipment_name'},
            {data: 'status'},
            {data: 'action',orderable: false, searchable: false}
        ]
    });
    $('#customSearch').on('keyup', function () {
    dataTable.search(this.value).draw();
  });
    });
    function edit_equipment(id)
{
    var csrf = "{{ csrf_token() }}";
    var url = "{{asset(config('constants.admin_path').'uploads/equipment/')}}";
      $.ajax({
            url: "{{ route('admin.equipment-details') }}",
            type: "get",
            dataType:"json",
            data: '_token='+csrf+'&equipment_id='+id,
            success: function (data) {
              if(data.error == 0)
              {
                $('#equipment_id').val(id);
                $('#equipment_name').val(data.name);
                $('#edit_equipment_modal').modal('show');
              }
            }
        });
}
</script>
@endsection
