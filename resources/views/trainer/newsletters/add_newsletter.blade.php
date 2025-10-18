@extends('trainer.layouts.app')
@section('title','SPLT | Newsletters')
@section('sub_title','Add Newsletter')
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Newsletter</a></li>
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
                <form id="add_newsletter" action="{{ route('trainer.add-newsletter') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                     <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="newsletter_image">Newsletter Image</label><br>
                            <img id="newsletter_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                            <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="newsletter_image" id="newsletter_image" class="custom-file-input">
                            </div>
                        </div>
                        @if($errors->has('newsletter_image'))
                            <p class="text-danger">{{ $errors->first('newsletter_image') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <div class="form-group">
                        <label for="newsletter_category">Category</label>
                        <select class="form-control" name="newsletter_category" id="newsletter_category" onchange="select_product();">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{$category->category_id}}" @if(old('newsletter_category') == $category->category_id) selected @endif>{{$category->category_name}}</option>
                            @endforeach
                        </select>
                         @if($errors->has('newsletter_category'))
                        <p class="text-danger">{{ $errors->first('newsletter_category') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                        <div class="form-group">
                        <label for="newsletter_product">Product</label>
                        <select class="form-control" name="newsletter_product" id="newsletter_product">
                            <option value="">Select</option>
                        </select>
                         @if($errors->has('newsletter_product'))
                        <p class="text-danger">{{ $errors->first('newsletter_product') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="newsletter_title">Newsletter Title</label>
                        <input type="text" class="form-control" name="newsletter_title" id="newsletter_title" value="{{old('newsletter_title')}}" autocomplete="off">
                        </div>
                        @if($errors->has('newsletter_title'))
                        <p class="text-danger">{{ $errors->first('newsletter_title') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="newsletter_description" id="newsletter_description" style="display:none">{{old('newsletter_description')}}</textarea>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('trainer.newsletters')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
   newsletter_image.onchange = evt => {
  const [file] = newsletter_image.files
  if (file) {
    newsletter_image_src.src = URL.createObjectURL(file)
  }
 }
 document.addEventListener('DOMContentLoaded', function () {
			ClassicEditor
			  .create(document.querySelector('#newsletter_description'))
			  .catch(error => {
				console.error(error);
			  });
		  });

function select_product()
{
    var category = $('#newsletter_category').val();
    var csrf = "{{ csrf_token() }}";

    if(category != "")
    {
        $.ajax({
            url:"{{route('trainer.select-product')}}",
            type:"post",
            data:'_token='+csrf+'&category='+category,
            success:function(data){
                $('#newsletter_product').html(data);
            }
            });
    }
}
</script>
@endsection
