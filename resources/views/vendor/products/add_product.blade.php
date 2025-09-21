@extends('vendor.layouts.app')
@section('title','SPLT | Products')
@section('sub_title','Products Management')
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
                            <li class="breadcrumb-item"><a href="{{route('vendor.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{route('vendor.products')}}">All Products</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Product</a></li>
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
                <form id="add_product" action="{{ route('vendor.add-product') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="product_name">Product name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" value="{{old('product_name')}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_name'))
                        <p class="text-danger">{{ $errors->first('product_name') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="brand">Select Brand</label>
                        <select class="form-control" name="product_brand" id="product_brand">
                            <option value="">Select</option>
                            @foreach($brands as $brand)
                            <option value="{{$brand->brand_id}}" @if(old('product_brand') == $brand->brand_id) selected @endif>{{$brand->brand_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        @if($errors->has('product_brand'))
                        <p class="text-danger">{{ $errors->first('product_brand') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control" name="product_category" id="product_category">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{$category->category_id}}" @if(old('product_category') == $category->category_id) selected @endif>{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        @if($errors->has('product_category'))
                        <p class="text-danger">{{ $errors->first('product_category') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="country">Select Country</label>
                        <select class="form-control" name="product_country" id="product_country">
                            <option value="">Select</option>
                            @foreach($countries as $country)
                            <option value="{{$country->country_id}}" @if(old('product_country') == $country->country_id) selected @endif>{{$country->country_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        @if($errors->has('product_country'))
                        <p class="text-danger">{{ $errors->first('product_country') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="product_sku">Product SKU</label>
                        <input type="text" class="form-control" name="product_sku" id="product_sku" value="{{old('product_sku')}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_sku'))
                        <p class="text-danger">{{ $errors->first('product_sku') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="product_warranty">Warranty</label>
                        <input type="text" class="form-control" name="product_warranty" id="product_warranty" value="{{old('product_warranty')}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_warranty'))
                        <p class="text-danger">{{ $errors->first('product_warranty') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="product_image">Image</label><br>
                        <img id="product_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        <div class="custom-file-wrapper">
                            <span class="file-name"></span>
                            <button type="button" class="browse-btn">Browse</button>
                            <input type="file" name="product_image" id="product_image" class="custom-file-input">
                        </div>
                        @if($errors->has('product_image'))
                        <p class="text-danger">{{ $errors->first('product_image') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="product_stock">Stock</label>
                        <input type="text" class="form-control" name="product_stock" id="product_stock" value="{{old('product_stock')}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_stock'))
                        <p class="text-danger">{{ $errors->first('product_stock') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="product_price">Price</label>
                        <div class="input-group">
                            {{-- <select class="form-select" aria-label="Select option">
                            <option value="INR">INR</option>
                            </select> --}}
                            <input type="text" class="form-control" name="product_price" id="product_price" value="{{old('product_price')}}" autocomplete="off">
                        </div>
                         @if($errors->has('product_price'))
                        <p class="text-danger">{{ $errors->first('product_price') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                        <label for="product_offer_price">Offer Price</label>
                        <div class="input-group">
                            {{-- <select class="form-select" aria-label="Select option">
                            <option value="INR">INR</option>
                            </select> --}}
                            <input type="text" class="form-control" name="product_offer_price" id="product_offer_price" value="{{old('product_price')}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_offer_price'))
                        <p class="text-danger">{{ $errors->first('product_offer_price') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="product_description" class="form-control" id="classic-editor">{{old('product_description')}}</textarea>
                        </div>
                    </div>
                    <h4>Variants</h4>
                     <div id="repeat">
                        <div class="row" id="itr1">
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="form-group">
                                <label for="country">Attribute</label>
                                <select class="form-control" id="product_attribute1" name="product_attribute[1]" id="product_attribute[1]" onchange="select_attribute(1)">
                                    <option value="">Select</option>
                                    @foreach($attributes as $attribute)
                                    <option value="{{$attribute->attribute_id}}">{{$attribute->attribute_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="form-group">
                                <label for="country">Attribute Value</label>
                                <select class="form-control product_attribute_value" id="product_attribute_value1" name="product_attribute_value[1]" id="product_attribute_value[1]">
                                    <option value="">Select</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12 mt-4">
                                <div class="form-group mt-3">
                                    <button type="button" class="btn btn-success" onclick="add_new()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                     </div>
                     <h4>Variant Price</h4>
                     <div id="variant_price">
                     </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('vendor.products')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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
   product_image.onchange = evt => {
    const [file] = product_image.files
    if (file) {
      product_image_src.src = URL.createObjectURL(file)
    }
   }

   function select_attribute(id)
    {
        var attribute = $('#product_attribute'+id).val();
        var csrf = "{{ csrf_token() }}";
        if(attribute != '')
        {
            $.ajax({
                    url: "{{ url('vendor/select_attribute') }}",
                    type: "post",
                    data: '_token='+csrf+'&attribute='+attribute,
                    success: function (data) {
                    $('#product_attribute_value'+id).html(data);
                    }
                });
        }

    }

    var i = 2;
    function add_new()
    {
    $('#repeat').append('<div class="row" id="itr'+i+'"><div class="col-lg-5 col-md-5 col-12"><div class="form-group"><label for="country">Attribute</label><select class="form-control" id="product_attribute'+i+'" name="product_attribute['+i+']" id="product_attribute['+i+']" onchange="select_attribute('+i+')"><option value="">Select</option>@foreach($attributes as $attribute)<option value="{{$attribute->attribute_id}}">{{$attribute->attribute_name}}</option>@endforeach</select></div></div><div class="col-lg-5 col-md-5 col-12"><div class="form-group"><label for="country">Attribute Value</label><select class="form-control product_attribute_value" id="product_attribute_value'+i+'" name="product_attribute_value['+i+']" id="product_attribute_value['+i+']"><option value="">Select</option></select></div></div><div class="col-lg-2 col-md-2 col-12 mt-4"><div class="form-group mt-3"><button type="button" class="btn btn-danger" onclick="remove('+i+')"><i class="fa fa-minus" aria-hidden="true"></i></button></div></div></div>');

    i = i+1;
    }
    function remove(id)
    {
    $('#itr'+id).remove();
    }

    $(document).on('change','.product_attribute_value',function(){
    var attributes = $('.product_attributes option:selected').map((_,el) => el.value).get();
    var attribute_val =   $('.product_attribute_value option:selected').map((_,el) => el.value).get();
    var csrf = "{{ csrf_token() }}";
      if(attribute_val != '')
      {
        $.ajax({
                url: "{{ url('vendor/attribute_price') }}",
                type: "post",
                data: '_token='+csrf+'&attribute_variation='+attribute_val+'&attributes='+attributes,
                success: function (data) {
                $('#variant_price').html(data);
                }
            });
      }

});
</script>
@endsection
