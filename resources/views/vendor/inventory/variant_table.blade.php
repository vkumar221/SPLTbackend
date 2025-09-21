<h4>Variants</h4>
<div class="table-responsive mb-3">
    <table class="table table-bordered">
        <thead>
            <th width="20%">Image</th>
            <th width="20%">Variant</th>
            <th width="10%">Price</th>
            <th width="10%">OfferPrice</th>
            <th width="20%">Existing Stock</th>
            <th width="20%">New Stock</th>
        </thead>
        <tbody>
            @foreach($variants as $key => $variant)
            <tr>
                <input type="hidden" name="product_variant_id[{{$variant->product_variant_id}}]" value="{{$variant->product_variant_id}}" >
                <td>
                    <img src="{{ asset(config('constants.vendor_path').'uploads/product/'.$variant->product_variant_image) }}" id="imagePreview{{$key}}" class="img-fluid d-flex mx-auto my-4 rounded" alt="Product img" width="68" >
                </td>
                <td>{{$variant->product_variant_name}}</td>
                <td>{{config('constants.currency_symbol')}} {{$variant->product_variant_price}}</td>
                <td>{{config('constants.currency_symbol')}} {{$variant->product_variant_offer_price}}</td>
                <td>{{$variant->product_variant_stock - $variant->product_variant_sale }}</td>
                <td><input type="number" class="form-control" name="inventory_stock[{{$variant->product_variant_id}}]" value="0" required></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
