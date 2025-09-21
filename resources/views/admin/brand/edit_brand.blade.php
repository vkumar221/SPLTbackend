@extends('admin.layouts.app')
@section('title','SPLT | Brands')
@section('sub_title','Brands Management')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.brands')}}">All Brands</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Brand</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="background-color:transparent;border-color:unset;border: none;">
            <div class="card-body p-0">
                <div class="form-wrapper">
                <form id="edit_brand" action="{{ route('admin.edit-brand',['id'=>$brand->brand_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="brand_name">Brand name</label>
                        <input type="text" class="form-control" name="brand_name" value="{{$brand->brand_name}}" id="brand_name">
                        </div>
                        @if($errors->has('brand_name'))
                        <p class="text-danger">{{ $errors->first('brand_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control" name="brand_category" id="brand_category">
                            <option value="1" @if($brand->brand_category == 1) selected @endif>New</option>
                            <option value="2" @if($brand->brand_category == 2) selected @endif>Existing</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="brand_image">Image</label><br>
                        @if($brand->brand_image != NULL)
                        <img class="mb-2" id="brand_image_src" src="{{ asset(config('constants.admin_path').'uploads/brand/'.$brand->brand_image)}}" alt="placeholder" width="68">
                        @else
                        <img id="brand_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        @endif
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="brand_image" id="brand_image" class="custom-file-input">
                        </div>
                        @if($errors->has('brand_image'))
                        <p class="text-danger">{{ $errors->first('banner_image') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="cover_image">Cover Image</label><br>
                        @if($brand->brand_cover_image != NULL)
                        <img class="mb-2" id="brand_cover_image_src" src="{{ asset(config('constants.admin_path').'uploads/brand/'.$brand->brand_cover_image)}}" alt="placeholder" width="68">
                        @else
                        <img id="brand_cover_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        @endif
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="brand_cover_image" id="brand_cover_image" class="custom-file-input">
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="brand_description" class="form-control" id="classic-editor">{{$brand->brand_description}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.brands')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

brand_image.onchange = evt => {
  const [file] = brand_image.files
  if (file) {
    brand_image_src.src = URL.createObjectURL(file)
  }
 }

  brand_cover_image.onchange = evt => {
  const [file] = brand_cover_image.files
  if (file) {
    brand_cover_image_src.src = URL.createObjectURL(file)
  }
}
</script>
@endsection
