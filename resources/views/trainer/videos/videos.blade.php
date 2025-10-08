@extends('trainer.layouts.app')
@section('title','SPLT | Videos')
@section('sub_title','Videos Management')
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
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Video Management</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-container">
            <a href="javascript:void(0)" class="btn-link" data-bs-toggle="modal" data-bs-target="#newSectionModal"><i class="ti ti-plus f-16"></i> Create Section</a>
            <a href="{{url('trainer/add_video')}}" class="btn-link"><i class="ti ti-plus f-16"></i> Add New Video</a>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        @foreach($video_sections as $video_section)
        <div class="videos-section">
            <div class="videos__head">
                <h3>{{$video_section->video_section_title}}</h3>
                <div class="action-button">
                    <a href="javascript:void(0);" class="action-link" onclick="edit_section({{$video_section->video_section_id}})"><img src="{{ asset(config('constants.admin_path').'images/icons/edit-blue.svg')}}" alt="edit"></a>
                    {{-- <a href="{{url('trainer/delete_video_section/'.$video_section->video_section_id)}}" class="action-link"><img src="{{ asset(config('constants.admin_path').'images/icons/trash-blue.svg')}}" alt="delete"></a> --}}
                </div>
            </div>
            <div class="videos-item__box">
                @if(isset($videos[$video_section->video_section_id]))
                    @foreach($videos[$video_section->video_section_id] as $video)
                    <div class="videos-item">
                        <div class="video-img">
                            <img src="{{ asset(config('constants.trainer_path').'uploads/video/'.$video->video_image)}}" alt="video">
                        </div>
                        <div class="video-content">
                            <ul class="details">
                            <li>Title : {{$video->video_title}}</li>
                            <li>Description : {{$video->video_description}}</li>
                            <li>Date : {{$video->video_date}}</li>
                            <li>Status : @if($video->video_status == 1) Private @else Public @endif</li>
                            <li class="mb-0">Time : {{$video->video_time}}</li>
                            </ul>
                        </div>
                        <div class="video-action__button">
                            <a href="{{url('trainer/edit_video/'.$video->video_id)}}" class="btn-edit"><img src="{{ asset(config('constants.admin_path').'images/icons/edit-white.svg')}}" alt="edit">Edit</a>
                            {{-- <a href="{{url('trainer/delete_video/'.$video->video_id)}}" class="btn-delete"><img src="{{ asset(config('constants.admin_path').'images/icons/trash-white.svg')}}" alt="delete">Delete</a> --}}
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="modal fade" id="newSectionModal" tabindex="-1" aria-labelledby="newSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="newSectionModalLabel">Create New Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="add_video_section" method="post" action="{{url('trainer/create_section')}}" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="video_section_title" autocomplete="off">
                    </div>
                    @if($errors->has('video_section_title'))
                        <p class="text-danger">{{ $errors->first('video_section_title') }}</p>
                    @endif
                </div>
                <div class="col-lg-12">
                <div class="form-group">
                    <div class="d-flex align-items-center" style="gap:20px">
                        <label for="private" class="mb-0">Private</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="video_section_status" id="flexSwitchCheckChecked" value="1" checked>
                        </div>
                    </div>
                </div>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-submit btn-primary" name="submit" value="submit">Submit</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="newSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="newSectionModalLabel">Edit Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="add_video_section" method="post" action="{{url('trainer/edit_section')}}" autocomplete="off">
            @csrf
            <div class="row">
                <input type="hidden" name="video_section_id" id="video_section_id">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="video_section_title" id="video_section_title" autocomplete="off">
                    </div>
                    @if($errors->has('video_section_title'))
                        <p class="text-danger">{{ $errors->first('video_section_title') }}</p>
                    @endif
                </div>
                <div class="col-lg-12">
                <div class="form-group">
                    <div class="d-flex align-items-center" style="gap:20px">
                    <label for="private" class="mb-0">Private</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="video_section_status" id="video_section_status" value="1">
                    </div>
                    </div>
                </div>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-submit btn-primary" name="submit" value="submit">Submit</button>
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
    function edit_section(id)
    {
        var csrf = "{{ csrf_token() }}";
        var url = "{{asset(config('constants.trainer_path').'uploads/video/')}}";
        $.ajax({
                url: "{{ route('trainer.section-details') }}",
                type: "get",
                dataType:"json",
                data: '_token='+csrf+'&section_id='+id,
                success: function (data) {
                if(data.error == 0)
                {
                    $('#video_section_id').val(id);
                    $('#video_section_title').val(data.name);
                    if(data.status == 1)
                    {
                       $('#video_section_status').prop('checked', true);
                    }
                    $('#editSectionModal').modal('show');
                }
                }
            });
    }
</script>
@endsection
