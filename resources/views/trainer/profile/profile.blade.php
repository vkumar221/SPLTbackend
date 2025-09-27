@extends('trainer.layouts.app')
@section('title','SPLT | Profile')
@section('sub_title','Profile Management')
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
                            <li class="breadcrumb-item"><a href="{{route('trainer.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
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
                <form id="edit_trainer" action="{{ route('trainer.profile') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                            <label for="trainer_image">Image</label><br>
                            @if(Auth::guard('trainer')->user()->trainer_image != NULL)
                            <img class="mb-2" id="trainer_image_src" src="{{ asset(config('constants.trainer_path').'uploads/profile/'.Auth::guard('trainer')->user()->trainer_image)}}" alt="placeholder" width="68">
                            @else
                            <img id="trainer_image_src" class="mb-2" src="{{ asset(config('constants.trainer_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                            @endif
                            <div class="custom-file-wrapper">
                                <span class="file-name"></span>
                                <button type="button" class="browse-btn">Browse</button>
                                <input type="file" name="trainer_image" id="trainer_image" class="custom-file-input">
                            </div>
                            @if($errors->has('trainer_image'))
                            <p class="text-danger">{{ $errors->first('trainer_image') }}</p>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                            <label for="trainer_name">Name</label>
                            <input type="text" class="form-control" name="trainer_name" value="{{Auth::guard('trainer')->user()->trainer_name}}" id="trainer_name" autocomplete="off">
                            </div>
                            @if($errors->has('trainer_name'))
                            <p class="text-danger">{{ $errors->first('trainer_name') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                            <label for="trainer_email">Email</label>
                            <input type="text" class="form-control" name="trainer_email" value="{{Auth::guard('trainer')->user()->trainer_email}}" id="trainer_email" autocomplete="off">
                            </div>
                            @if($errors->has('trainer_email'))
                            <p class="text-danger">{{ $errors->first('trainer_email') }}</p>
                            @endif
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-action__button">
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

trainer_image.onchange = evt => {
  const [file] = trainer_image.files
  if (file) {
    trainer_image_src.src = URL.createObjectURL(file)
  }
 }
</script>
@endsection
