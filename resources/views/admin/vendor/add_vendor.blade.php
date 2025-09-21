@extends('admin.layouts.app')
@section('title','SPLT | Vendors')
@section('sub_title','Vendors Management')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.vendors')}}">All Vendors</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Vendor</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="form-wrapper">
                <form id="add_vendor" action="{{ route('admin.add-vendor') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="vendor_name">Vendor name</label>
                        <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{old('vendor_name')}}" autocomplete="off">
                        </div>
                        @if($errors->has('vendor_name'))
                        <p class="text-danger">{{ $errors->first('vendor_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="vendor_email">Vendor Email</label>
                        <input type="text" class="form-control" name="vendor_email" id="vendor_email" value="{{old('vendor_email')}}" autocomplete="off">
                        </div>
                        @if($errors->has('vendor_email'))
                        <p class="text-danger">{{ $errors->first('vendor_email') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="vendor_phone">Vendor Phone</label>
                        <input type="text" class="form-control" name="vendor_phone" id="vendor_phone" value="{{old('vendor_phone')}}" autocomplete="off">
                        </div>
                        @if($errors->has('vendor_phone'))
                        <p class="text-danger">{{ $errors->first('vendor_phone') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="category">Select Type</label>
                        <select class="form-control" name="vendor_type" id="vendor_type">
                            <option value="1" @if(old('vendor_type') == 1) selected @endif>New</option>
                            <option value="2" @if(old('vendor_type') == 2) selected @endif>Existing</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="vendor_password">Vendor Password</label>
                        <input type="password" class="form-control" name="vendor_password" id="vendor_password" value="{{old('vendor_password')}}" autocomplete="off">
                        </div>
                        @if($errors->has('vendor_phone'))
                        <p class="text-danger">{{ $errors->first('vendor_phone') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="vendor_image">Image</label><br>
                        <img id="vendor_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="vendor_image" id="vendor_image" class="custom-file-input">
                        </div>
                        @if($errors->has('vendor_image'))
                        <p class="text-danger">{{ $errors->first('banner_image') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.vendors')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

 vendor_image.onchange = evt => {
  const [file] = vendor_image.files
  if (file) {
    vendor_image_src.src = URL.createObjectURL(file)
  }
 }

</script>
@endsection
