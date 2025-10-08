@extends('trainer.layouts.app')
@section('title','SPLT | Clients')
@section('sub_title','Clients Management')
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
                            <li class="breadcrumb-item"><a href="{{route('trainer.clients')}}">All Clients</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Client</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="form-wrapper">
                <form id="edit_client" action="{{ route('trainer.edit-client',['id'=>$user->id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="fname">First name</label>
                        <input type="text" class="form-control" name="fname" id="fname" value="{{$user->fname}}" autocomplete="off">
                        </div>
                        @if($errors->has('fname'))
                        <p class="text-danger">{{ $errors->first('fname') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="lname">Last name</label>
                        <input type="text" class="form-control" name="lname" id="lname" value="{{$user->lname}}" autocomplete="off">
                        </div>
                        @if($errors->has('lname'))
                        <p class="text-danger">{{ $errors->first('lname') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}" autocomplete="off">
                        </div>
                        @if($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{$user->phone}}" autocomplete="off">
                        </div>
                        @if($errors->has('phone'))
                        <p class="text-danger">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="uname">User name</label>
                        <input type="text" class="form-control" name="uname" id="uname" value="{{$user->uname}}" autocomplete="off">
                        </div>
                        @if($errors->has('uname'))
                        <p class="text-danger">{{ $errors->first('uname') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" value="" autocomplete="off">
                        </div>
                        @if($errors->has('password'))
                        <p class="text-danger">{{ $errors->first('password') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="client_image">Image</label><br>
                        <img id="client_image_src" class="mb-2" src="{{ asset(config('constants.user_path').'uploads/profile/'.$user->image)}}" alt="placeholder" width="100">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="image" id="client_image" class="custom-file-input">
                        </div>
                        @if($errors->has('image'))
                        <p class="text-danger">{{ $errors->first('image') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('trainer.clients')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

  client_image.onchange = evt => {
  const [file] = client_image.files
  if (file) {
    client_image_src.src = URL.createObjectURL(file)
  }
 }

</script>
@endsection
