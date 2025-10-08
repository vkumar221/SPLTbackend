@extends('trainer.layouts.app')
@section('title','SPLT | Videos')
@section('sub_title','Videos')
@section('import_export')
<li class="pc-h-item">
</li>
<li class="pc-h-item">
</li>
@endsection
@section('custom_style')
<link rel="stylesheet" href="{{ asset(config('constants.admin_path').'css/trainer.css')}}" />
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
                            <li class="breadcrumb-item"><a href="{{route('trainer.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{route('trainer.videos')}}">Video Management</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Video</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="trainer-form__wrapper">
                    <form id="edit_video" action="{{ route('trainer.edit-video',['id'=>$video->video_id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label for="video_image">Thumb Image</label><br>
                                    <img id="video_image_src" class="mb-2" src="{{ asset(config('constants.trainer_path').'uploads/video/'.$video->video_image)}}" alt="placeholder" width="68" height="68">
                                    <div class="custom-file-wrapper">
                                    <span class="file-name"></span>
                                    <button type="button" class="browse-btn">Browse</button>
                                    <input type="file" name="video_image" id="video_image" class="custom-file-input">
                                    </div>
                                    @if($errors->has('video_image'))
                                    <p class="text-danger">{{ $errors->first('video_image') }}</p>
                                @endif
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                <div class="upload-container">
                                    <div class="youtube-input">
                                        <input type="text" name="video_vimeo" value="{{$video->video_vimeo}}" placeholder="Paste a Vimeo video link" autocomplete="off">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M9.58979 14.3034L8.41128 15.4819C6.7841 17.1091 4.14591 17.1091 2.51873 15.4819C0.891542 13.8547 0.891543 11.2165 2.51873 9.58931L3.69724 8.4108M14.3039 9.58931L15.4824 8.4108C17.1096 6.78362 17.1096 4.14543 15.4824 2.51824C13.8552 0.891056 11.217 0.891056 9.58979 2.51824L8.41128 3.69676M6.08387 11.9167L11.9172 6.08337" stroke="#9DA4AE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    <div class="divider-or">or</div>

                                    <div class="youtube-input">
                                        <input type="text" name="video_youtube" value="{{$video->video_youtube}}" placeholder="Paste a YouTube video link" autocomplete="off">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M9.58979 14.3034L8.41128 15.4819C6.7841 17.1091 4.14591 17.1091 2.51873 15.4819C0.891542 13.8547 0.891543 11.2165 2.51873 9.58931L3.69724 8.4108M14.3039 9.58931L15.4824 8.4108C17.1096 6.78362 17.1096 4.14543 15.4824 2.51824C13.8552 0.891056 11.217 0.891056 9.58979 2.51824L8.41128 3.69676M6.08387 11.9167L11.9172 6.08337" stroke="#9DA4AE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-2">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="video_title" id="video_title" value="{{$video->video_title}}" autocomplete="off">
                            </div>
                            @if($errors->has('video_title'))
                                <p class="text-danger">{{ $errors->first('video_title') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-2">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" name="video_description" id="video_description" value="{{$video->video_description}}" autocomplete="off">
                            </div>
                            @if($errors->has('video_description'))
                                <p class="text-danger">{{ $errors->first('video_description') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-2">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="video_date" id="video_date" value="{{$video->video_date}}" autocomplete="off">
                            </div>
                            @if($errors->has('video_date'))
                                <p class="text-danger">{{ $errors->first('video_date') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-2">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" name="video_time" id="video_time" value="{{$video->video_time}}" autocomplete="off">
                            </div>
                            @if($errors->has('video_time'))
                                <p class="text-danger">{{ $errors->first('video_time') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-12 col-md-12 col-2">
                            <div class="form-group">
                                <label for="section">Select Section</label>
                                <select class="form-control" name="video_section" id="video_section">
                                    <option value="">Select...</option>
                                    @foreach($video_sections as $video_section)
                                    <option value="{{$video_section->video_section_id}}" @if($video->video_section == $video_section->video_section_id) selected @endif>{{$video_section->video_section_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('video_section'))
                                <p class="text-danger">{{ $errors->first('video_section') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center" style="gap:20px">
                                <div class="d-flex align-items-center" style="gap:20px">
                                    <label for="private" class="mb-0">Private</label>
                                    <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="video_status" role="switch" id="flexSwitchCheckChecked" value="1" @if($video->video_status == 1) checked @endif>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label mb-0" for="customCheckclight2">Featured</label>
                                    <input class="form-check-input input-light-secondary" type="checkbox" name="video_featured" id="customCheckclight2" value="1" @if($video->video_featured == 1) checked @endif>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-action__button">
                            <a href="{{route('trainer.videos')}}" class="btn-link btn-back"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
   video_image.onchange = evt => {
  const [file] = video_image.files
  if (file) {
    video_image_src.src = URL.createObjectURL(file)
  }
 }
</script>
@endsection
