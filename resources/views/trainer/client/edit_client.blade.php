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
                <form id="edit_client" action="{{ route('trainer.edit-client',['id'=>$client->client_id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="client_name">Client name</label>
                        <input type="text" class="form-control" name="client_name" id="client_name" value="{{$client->client_name}}" autocomplete="off">
                        </div>
                        @if($errors->has('client_name'))
                        <p class="text-danger">{{ $errors->first('client_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="client_email">Client Email</label>
                        <input type="text" class="form-control" name="client_email" id="client_email" value="{{$client->client_email}}" autocomplete="off">
                        </div>
                        @if($errors->has('client_email'))
                        <p class="text-danger">{{ $errors->first('client_email') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="client_phone">Client Phone</label>
                        <input type="text" class="form-control" name="client_phone" id="client_phone" value="{{$client->client_phone}}" autocomplete="off">
                        </div>
                        @if($errors->has('client_phone'))
                        <p class="text-danger">{{ $errors->first('client_phone') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="category">Select Type</label>
                        <select class="form-control" name="client_type" id="client_type">
                            <option value="1" @if($client->client_type == 1) selected @endif>New</option>
                            <option value="2" @if($client->client_type == 2) selected @endif>Existing</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="client_password">Client Password</label>
                        <input type="password" class="form-control" name="client_password" id="client_password" value="" autocomplete="off">
                        </div>
                        @if($errors->has('client_phone'))
                        <p class="text-danger">{{ $errors->first('client_phone') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="client_image">Image</label><br>
                        <img id="client_image_src" class="mb-2" src="{{ asset(config('constants.client_path').'uploads/profile/'.$client->client_image)}}" alt="placeholder" width="100">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="client_image" id="client_image" class="custom-file-input">
                        </div>
                        @if($errors->has('client_image'))
                        <p class="text-danger">{{ $errors->first('banner_image') }}</p>
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
