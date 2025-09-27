@extends('admin.layouts.app')
@section('title','SPLT |Workout Categories')
@section('sub_title','Workout Categories')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.workout-categories')}}">All Workout Categories</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Workout Category</a></li>
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
                <form id="add_workout_category" action="{{ route('admin.add-workout-category') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="workout_category_name">Category name</label>
                        <input type="text" class="form-control" name="workout_category_name" id="workout_category_name" autocomplete="off">
                        </div>
                        @if($errors->has('workout_category_name'))
                        <p class="text-danger">{{ $errors->first('workout_category_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="workout_category_image">Image</label><br>
                        <img id="workout_category_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="100">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="workout_category_image" id="workout_category_image" class="custom-file-input">
                        </div>
                        @if($errors->has('workout_category_image'))
                        <p class="text-danger">{{ $errors->first('workout_category_image') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="cover_image">Cover Image</label><br>
                        <img id="workout_category_cover_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="100">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="workout_category_cover_image" id="workout_category_cover_image" class="custom-file-input">
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="featured_image">Featured Image</label><br>
                        <img id="workout_category_feature_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="100">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="workout_category_feature_image" id="workout_category_feature_image" class="custom-file-input">
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="workout_category_description" class="form-control" id="classic-editor"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('admin.workout-categories')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

 workout_category_image.onchange = evt => {
  const [file] = workout_category_image.files
  if (file) {
    workout_category_image_src.src = URL.createObjectURL(file)
  }
 }
    workout_category_feature_image.onchange = evt => {
  const [file] = workout_category_feature_image.files
  if (file) {
    workout_category_feature_image_src.src = URL.createObjectURL(file)
  }
 }

  workout_category_cover_image.onchange = evt => {
  const [file] = workout_category_cover_image.files
  if (file) {
    workout_category_cover_image_src.src = URL.createObjectURL(file)
  }
}
</script>
@endsection
