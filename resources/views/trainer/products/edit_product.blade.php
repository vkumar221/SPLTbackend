@extends('trainer.layouts.app')
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
                            <li class="breadcrumb-item"><a href="{{route('trainer.dashboard-page')}}">Home</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="{{route('trainer.products')}}">All Products</a></li>
                            <li class="breadcrumb-item text-white">/</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Product</a></li>
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
                <form id="edit_product" action="{{ route('trainer.edit-product',['id'=>$product->product_id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="product_name">Product name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" value="{{$product->product_name}}" autocomplete="off">
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
                            <option value="{{$brand->brand_id}}" @if($product->product_brand == $brand->brand_id) selected @endif>{{$brand->brand_name}}</option>
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
                            <option value="{{$category->category_id}}" @if($product->product_category == $category->category_id) selected @endif>{{$category->category_name}}</option>
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
                            <option value="{{$country->country_id}}" @if($product->product_country == $country->country_id) selected @endif>{{$country->country_name}}</option>
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
                        <input type="text" class="form-control" name="product_sku" id="product_sku" value="{{$product->product_sku}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_sku'))
                        <p class="text-danger">{{ $errors->first('product_sku') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                        <label for="product_warranty">Warranty</label>
                        <input type="text" class="form-control" name="product_warranty" id="product_warranty" value="{{$product->product_warranty}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_warranty'))
                        <p class="text-danger">{{ $errors->first('product_warranty') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="product_image">Image</label><br>
                         @if($product->product_image != NULL)
                        <img class="mb-2" id="product_image_src" src="{{ asset(config('constants.vendor_path').'uploads/product/'.$product->product_image)}}" alt="placeholder" width="68">
                        @else
                        <img id="product_image_src" class="mb-2" src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" alt="placeholder" width="68" height="68">
                        @endif
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
                        <input type="text" class="form-control" name="product_stock" id="product_stock" value="{{$product->product_stock}}" autocomplete="off">
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
                            <input type="text" class="form-control" name="product_price" id="product_price" value="{{$product->product_price}}" autocomplete="off">
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
                            <input type="text" class="form-control" name="product_offer_price" id="product_offer_price" value="{{$product->product_offer_price}}" autocomplete="off">
                        </div>
                        @if($errors->has('product_offer_price'))
                        <p class="text-danger">{{ $errors->first('product_offer_price') }}</p>
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="product_description" class="form-control" id="classic-editor">{{$product->product_description}}</textarea>
                        </div>
                    </div>
                                        @if(count($variants) > 0)
                    <h4>Variants</h4>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <th width="20%">Image</th>
                                <th width="20%">Variant</th>
                                <th width="10%">Price</th>
                                <th width="10%">OfferPrice</th>
                                <th width="20%">Stock</th>
                                <th width="20%">Stock Count</th>
                            </thead>
                            <tbody>
                                @foreach($variants as $key => $variant)
                                <tr>
                                    <input type="hidden" name="product_variant_id[{{$key}}]" value="{{$variant->product_variant_id}}" >
                                    <td>
                                        <img src="{{ asset(config('constants.vendor_path').'uploads/product/'.$variant->product_variant_image) }}" id="imagePreview{{$key}}" class="img-fluid d-flex mx-auto my-4 rounded" alt="Product img" width="68" >
                                        <div class="button-wrapper text-center">
                                            <label for="imageInput{{$key}}" class="btn btn-sm btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0" onclick="preview_image({{$key}})">
                                                <span class="d-none d-sm-block">Change</span>
                                                <i class="ti ti-upload d-block d-sm-none"></i>
                                                <input type="file" name="product_variant_image{{$key}}" id="imageInput{{$key}}" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{$variant->product_variant_name}}</td>
                                    <td><input type="number" class="form-control" name="product_variant_price[{{$key}}]" value="{{$variant->product_variant_price}}" required></td>
                                    <td><input type="number" class="form-control" name="product_variant_offer_price[{{$key}}]" value="{{$variant->product_variant_offer_price}}" required></td>
                                    <td>
                                        <select class="form-control" name="product_variant_status[{{$key}}]" required>
                                            <option value="">Select</option>
                                            <option value="1" @if($variant->product_variant_status == 1) selected @endif>In stock</option>
                                            <option value="2" @if($variant->product_variant_status == 2) selected @endif>Out of stock</option>
                                        </select>
                                    </td>
                                    <td>{{$variant->product_variant_stock}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-action__button">
                        <a href="{{route('trainer.products')}}" class="btn-link btn-white"><img style="margin-right:5px" src="{{ asset(config('constants.admin_path').'images/icons/arrow-left.svg')}}" alt="arrow-left">Back</a>
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

$('[id^="imageInput"]').on('change', function () {
    const inputId = $(this).attr('id');
    const suffix = inputId.replace('imageInput', '');
    const previewId = '#imagePreview' + suffix;

    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $(previewId).attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});

</script>
@endsection

