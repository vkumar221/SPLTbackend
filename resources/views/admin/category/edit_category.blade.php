@extends('admin.layouts.app')
@section('title','SPLT | Categories')
@section('sub_title','Categories Management')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.categories')}}">All Categories</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Category</a></li>
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
                <form id="edit_category" action="{{ route('admin.edit-category',['id'=>$category->category_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="category_name">Category name</label>
                        <input type="text" class="form-control" name="category_name" value="{{$category->category_name}}" id="category_name">
                        </div>
                        @if($errors->has('category_name'))
                        <p class="text-danger">{{ $errors->first('category_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="category_image">Image</label><br>
                        @if($category->category_image != NULL)
                        <img class="mb-2" id="category_image_src" src="{{ asset(config('constants.admin_path').'uploads/category/'.$category->category_image)}}" alt="placeholder" width="68">
                        @else
                        <img id="category_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        @endif
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="category_image" id="category_image" class="custom-file-input">
                        </div>
                        @if($errors->has('category_image'))
                        <p class="text-danger">{{ $errors->first('banner_image') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="cover_image">Cover Image</label><br>
                        @if($category->category_cover_image != NULL)
                        <img class="mb-2" id="category_cover_image_src" src="{{ asset(config('constants.admin_path').'uploads/category/'.$category->category_cover_image)}}" alt="placeholder" width="68">
                        @else
                        <img id="category_cover_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        @endif
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="category_cover_image" id="category_cover_image" class="custom-file-input">
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="featured_image">Featured Image</label><br>
                        @if($category->category_feature_image != NULL)
                        <img class="mb-2" id="category_feature_image_src" src="{{ asset(config('constants.admin_path').'uploads/category/'.$category->category_feature_image)}}" alt="placeholder" width="68">
                        @else
                        <img id="category_feature_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        @endif
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="category_feature_image" id="category_feature_image" class="custom-file-input">
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="category_description" class="form-control" id="classic-editor">{{$category->category_description}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.categories')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

category_image.onchange = evt => {
  const [file] = category_image.files
  if (file) {
    category_image_src.src = URL.createObjectURL(file)
  }
 }
    category_feature_image.onchange = evt => {
  const [file] = category_feature_image.files
  if (file) {
    category_feature_image_src.src = URL.createObjectURL(file)
  }
 }

  category_cover_image.onchange = evt => {
  const [file] = category_cover_image.files
  if (file) {
    category_cover_image_src.src = URL.createObjectURL(file)
  }
}
</script>
@endsection
