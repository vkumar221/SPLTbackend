@extends('admin.layouts.app')
@section('title','SPLT | Trainers')
@section('sub_title','Trainers Management')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.trainers')}}">All Trainers</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Trainer</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="form-wrapper">
                <form id="edit_trainer" action="{{ route('admin.edit-trainer',['id'=>$trainer->trainer_id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="trainer_name">Trainer name</label>
                        <input type="text" class="form-control" name="trainer_name" id="trainer_name" value="{{$trainer->trainer_name}}" autocomplete="off">
                        </div>
                        @if($errors->has('trainer_name'))
                        <p class="text-danger">{{ $errors->first('trainer_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="trainer_email">Trainer Email</label>
                        <input type="text" class="form-control" name="trainer_email" id="trainer_email" value="{{$trainer->trainer_email}}" autocomplete="off">
                        </div>
                        @if($errors->has('trainer_email'))
                        <p class="text-danger">{{ $errors->first('trainer_email') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="trainer_phone">Trainer Phone</label>
                        <input type="text" class="form-control" name="trainer_phone" id="trainer_phone" value="{{$trainer->trainer_phone}}" autocomplete="off">
                        </div>
                        @if($errors->has('trainer_phone'))
                        <p class="text-danger">{{ $errors->first('trainer_phone') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="category">Select Type</label>
                        <select class="form-control" name="trainer_type" id="trainer_type">
                            <option value="1" @if($trainer->trainer_type == 1) selected @endif>New</option>
                            <option value="2" @if($trainer->trainer_type == 2) selected @endif>Existing</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="trainer_password">Trainer Password</label>
                        <input type="password" class="form-control" name="trainer_password" id="trainer_password" value="" autocomplete="off">
                        </div>
                        @if($errors->has('trainer_phone'))
                        <p class="text-danger">{{ $errors->first('trainer_phone') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="trainer_image">Image</label><br>
                        <img id="trainer_image_src" class="mb-2" src="{{ asset(config('constants.trainer_path').'uploads/profile/'.$trainer->trainer_image)}}" alt="placeholder" width="100">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="trainer_image" id="trainer_image" class="custom-file-input">
                        </div>
                        @if($errors->has('trainer_image'))
                        <p class="text-danger">{{ $errors->first('banner_image') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.trainers')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
