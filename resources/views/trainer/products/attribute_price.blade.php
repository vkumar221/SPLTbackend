@if(count($combinations) > 0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th width="20%">Variant</th>
            <th width="10%">Price</th>
            <th width="10%">Offer Price</th>
            <th width="20%">Stock</th>
            <th width="20%">Stock Count</th>
            <th width="20%">Image</th>
        </thead>
        <tbody>
            @foreach($combinations as $key => $combination)
            <tr>
                <input type="hidden" name="attribute_ids[{{$key}}]" value="{{$attribute_ids[$key]}}" >
                <input type="hidden" name="product_variant_name[{{$key}}]" value="{{$combination}}">
                <td>{{$combination}}</td>
                <td><input type="number" class="form-control" name="product_variant_price[{{$key}}]" required></td>
                <td><input type="number" class="form-control" name="product_variant_offer_price[{{$key}}]" required></td>
                <td>
                    <select class="form-control" name="product_variant_status[{{$key}}]" required>
                        <option value="">Select</option>
                        <option value="1">In stock</option>
                        <option value="2">Out of stock</option>
                    </select>
                </td>
                <td><input type="number" class="form-control" name="product_variant_stock[{{$key}}]" required></td>
                <td>
                    <img src="{{ asset(config('constants.admin_path').'images/placeholder.png')}}" id="imagePreview{{$key}}" class="img-fluid d-flex mx-auto my-4 rounded" alt="Product img" width="68" >
                    <div class="button-wrapper text-center">
                        <label for="imageInput{{$key}}" class="btn btn-sm btn-primary me-2 waves-effect waves-light" tabindex="0">
                            <span class="d-none d-sm-block">Choose Image</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" name="product_variant_image{{$key}}" id="imageInput{{$key}}" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                        </label>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<script>
    $('[id^="imageInput"]').on('change', function () {
    const inputId = $(this).attr('id');            // e.g. imageInput2
    const suffix = inputId.replace('imageInput', ''); // e.g. 2
    const previewId = '#imagePreview' + suffix;    // e.g. #imagePreview2

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
