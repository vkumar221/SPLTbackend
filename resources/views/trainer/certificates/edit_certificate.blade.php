@extends('trainer.layouts.app')
@section('title','SPLT | Certificates')
@section('sub_title','Certificates')
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Certificate</a></li>
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
                <form id="add_certificate" action="{{ route('trainer.edit-certificate',['id'=>$certificate->certificate_id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                     <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="certificate_image">Certificate Image</label><br>
                            <img id="certificate_image_src" class="mb-2" src="{{ asset(config('constants.trainer_path').'uploads/certificate/'.$certificate->certificate_image)}}" alt="placeholder" width="68" height="68">
                            <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="certificate_image" id="certificate_image" class="custom-file-input">
                            </div>
                        </div>
                        @if($errors->has('certificate_image'))
                            <p class="text-danger">{{ $errors->first('certificate_image') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="certificate_title">Title</label>
                        <input type="text" class="form-control" name="certificate_title" id="certificate_title" value="{{$certificate->certificate_title}}" autocomplete="off">
                        @if($errors->has('certificate_title'))
                        <p class="text-danger">{{ $errors->first('certificate_title') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('trainer.certificates')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
   certificate_image.onchange = evt => {
  const [file] = certificate_image.files
  if (file) {
    certificate_image_src.src = URL.createObjectURL(file)
  }
 }
</script>
@endsection
