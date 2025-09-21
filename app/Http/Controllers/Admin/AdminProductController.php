<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use DB;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Inventory;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\AttributeVariation;
class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'product';
        $data['categories'] = Category::where('category_status',1)->get();
        $data['vendors'] = Vendor::where('vendor_status',1)->get();
        return view('admin.products.products',$data);
    }

    public function get_products(Request $request)
    {
        if($request->ajax())
        {
            $where['product_trash'] = 0;
            if(!empty($request->category))
            {
                $where['product_category'] = $request->category;
            }
            if(!empty($request->vendor))
            {
                $where['product_vendor'] = $request->vendor;
            }

            $data = Product::getDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->product_added_on));

                        return $added_on;
                    })
                    ->addColumn('image',function($row)
                    {
                        if($row->product_image == NULL)
                        {
                            $image = '<div class="d-flex;align-items-center">
										    <img src="'.asset(config("constants.admin_path")."images/placeholder.png").'" alt="placeholder" width="37" height="37">
										    <span>'.$row->product_name.'</span>
										  </div>';
                        }
                        else
                        {
                            $image = '<div class="d-flex;align-items-center">
										    <img src="'.url('assets/vendor/uploads/product/'.$row->product_image).'" alt="placeholder" width="37" height="37">
										    <span>'.$row->product_name.'</span>
										  </div>';
                        }
                        return $image;
                    })
                    ->addColumn('price',function($row)
                    {
                        $price = config('constants.currency_symbol').' '.$row->product_price;
                        return $price;
                    })
                     ->addColumn('status', function($row)
                    {
                        if($row->category_status == 1)
                        {
                            $status = '<span class="status-label text-white">Active</span>';
                        }
                        else
                        {
                            $status = '<span class="status-label text-white">Disable</span>';
                        }

                        return $status;

                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('admin/edit_product/'.$row->product_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        // $btn .= '<a href="'.url('admin/product_gallery/'.$row->product_id).'" class="btn btn-icon btn-sm bg-violet text-white" title="Gallery"><i class="fa fa-image"></i></a> ';

                        if($row->product_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/product_status/'.$row->product_id.'/'.$row->product_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/product_status/'.$row->product_id.'/'.$row->product_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_product(Request $request)
    {
        $data['set'] = 'products';
        $data['categories'] = Category::where('category_status',1)->get();
        $data['countries'] = DB::table('countries')->where('country_status',1)->get();
        $data['vendors'] = Vendor::where('vendor_status',1)->get();
        $data['brands'] = Brand::where('brand_status',1)->get();
        $data['attributes'] = Attribute::where('attribute_status',1)->get();
        return view('admin.products.add_product',$data);
    }

    public function create_product(Request $request)
    {
        if($request->has('submit'))
        {
             $rules = [ 'product_name' => 'required',
                       'product_category' => 'required',
                       'product_brand' => 'required',
                       'product_vendor' => 'required',
                       'product_country' => 'required',
                       'product_price' => 'required',
                       'product_offer_price' => 'required',
                       'product_stock' => 'required',
                       'product_sku' => 'required',
                       'product_offer_price' => 'required',
                       'product_description' => 'required',];

            $messages = ['product_name.required'=>'Please enter name',
                        'product_description.required'=>'Please enter description',
                        'product_category.required'=>'Please choose category',
                        'product_vendor.required'=>'Please choose vendor',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['product_slug'] = Str::slug($request->product_name);
            $where['product_category'] = $request->product_category;
            $check = Product::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['product_name']               = $request->product_name;
            $ins['product_slug']               = Str::slug($request->product_name);
            $ins['product_category']           = $request->product_category;
            $ins['product_vendor']             = $request->product_vendor;
            $ins['product_country']            = $request->product_country;
            $ins['product_tags']               = $request->product_tags;
            $ins['product_sku']                = $request->product_sku;
            $ins['product_warranty']           = $request->product_warranty;
            $ins['product_stock']              = $request->product_stock;
            $ins['product_price']              = $request->product_price;
            $ins['product_offer_price']        = $request->product_offer_price;
            $ins['product_description']        = $request->product_description;
            $ins['product_status']             = 1;
            $ins['product_added_by']           = Auth::guard('admin')->user()->admin_id;
            $ins['product_added_on']           = date('Y-m-d H:i:s');
            $ins['product_updated_by']         = Auth::guard('admin')->user()->admin_id;
            $ins['product_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('product_image'))
            {
                $product_image = $request->product_image->store('assets/vendor/uploads/product');

                $product_image = explode('/',$product_image);
                $product_image = end($product_image);
                $ins['product_image'] = $product_image;
            }

            $product_id = Product::insertGetId($ins);

            foreach($request->attribute_ids as $key => $product_variant_attribute)
            {
                $var_attri = json_decode($product_variant_attribute,true);
                $insVar['product_variant_product']     = $product_id;
                $insVar['product_variant_attribute']   = $product_variant_attribute;
                $insVar['product_variant_name']        = $request->product_variant_name[$key];
                $insVar['product_variant_price']       = $request->product_variant_price[$key];
                $insVar['product_variant_offer_price'] = $request->product_variant_offer_price[$key];
                $insVar['product_variant_stock']       = $request->product_variant_stock[$key];
                $insVar['product_variant_status']      = $request->product_variant_status[$key];
                $insVar['product_variant_added_by']    = Auth::guard('admin')->user()->admin_id;
                $insVar['product_variant_added_on']    = date('Y-m-d H:i:s');
                $insVar['product_variant_updated_by']  = Auth::guard('admin')->user()->admin_id;
                $insVar['product_variant_updated_on']  = date('Y-m-d H:i:s');

                if($request->hasFile('product_variant_image'.$key))
                {
                    $product_image = $request->file('product_variant_image'.$key)->store('assets/vendor/uploads/product');
                    $product_image = explode('/',$product_image);
                    $product_image = end($product_image);
                    $insVar['product_variant_image'] = $product_image;
                }

                $variant_id = ProductVariant::insertGetId($insVar);

                $insInv['inventory_product']     = $product_id;
                $insInv['inventory_variant']     = $variant_id;
                $insInv['inventory_open_stock']  = 0;
                $insInv['inventory_close_stock'] = $request->product_variant_stock[$key];
                $insInv['inventory_added_by']    = Auth::guard('admin')->user()->admin_id;
                $insInv['inventory_added_on	']   = date('Y-m-d H:i:s');
                $insInv['inventory_updated_by']  = Auth::guard('admin')->user()->admin_id;
                $insInv['inventory_updated_on']  = date('Y-m-d H:i:s');

                $inventory = Inventory::create($insInv);

            }

            if($product_id)
            {
                return redirect()->back()->with('success','Product Added Successfully');
            }
        }
    }

    public function edit_product(Request $request)
    {
        $data['product'] = $product = Product::where('product_id',$request->segment(3))->first();
        $data['categories'] = Category::where('category_status',1)->get();
        $data['countries'] = DB::table('countries')->where('country_status',1)->get();
        $data['vendors'] = Vendor::where('vendor_status',1)->get();
        $data['brands'] = Brand::where('brand_status',1)->get();
        $data['variants'] = ProductVariant::where('product_variant_product',$product->product_id)->get();

        if(!isset($data['product']))
        {
            return redirect('admin/product');
        }

        $data['set'] = 'products';
        return view('admin.products.edit_product',$data);
    }

    public function update_product(Request $request)
    {
        $product = Product::where('product_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
            $rules = [ 'product_name' => 'required',
                       'product_category' => 'required',
                       'product_brand' => 'required',
                       'product_vendor' => 'required',
                       'product_country' => 'required',
                       'product_price' => 'required',
                       'product_offer_price' => 'required',
                       'product_stock' => 'required',
                       'product_sku' => 'required',
                       'product_warranty' => 'required',
                       'product_offer_price' => 'required',
                       'product_description' => 'required',];

            $messages = ['product_name.required'=>'Please enter name',
                        'product_description.required'=>'Please enter description',
                        'product_category.required'=>'Please choose category',
                        'product_vendor.required'=>'Please choose vendor',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['product_slug'] = Str::slug($request->product_name);
            $where['product_category'] = $request->product_category;
            $check_name = Product::where($where)->where('product_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['product_name']               = $request->product_name;
            $upd['product_slug']               = Str::slug($request->product_name);
            $upd['product_category']           = $request->product_category;
            $upd['product_vendor']             = $request->product_vendor;
            $upd['product_country']            = $request->product_country;
            $upd['product_tags']               = $request->product_tags;
            $upd['product_sku']                = $request->product_sku;
            $upd['product_warranty']           = $request->product_warranty;
            $upd['product_stock']              = $request->product_stock;
            $upd['product_price']              = $request->product_price;
            $upd['product_offer_price']        = $request->product_offer_price;
            $upd['product_description']        = $request->product_description;
            $upd['product_updated_by']         = Auth::guard('admin')->user()->admin_id;
            $upd['product_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('product_image'))
            {
                $product_image = $request->product_image->store('assets/vendor/uploads/product');

                $product_image = explode('/',$product_image);
                $product_image = end($product_image);
                $upd['product_image'] = $product_image;
            }

            $update = Product::where('product_id',$request->segment(3))->update($upd);

            foreach($request->product_variant_id as $key => $product_variant_id)
            {
                $variant = ProductVariant::find($product_variant_id);

                $variant->product_variant_price      = $request->product_variant_price[$key];
                $variant->product_variant_offer_price = $request->product_variant_offer_price[$key];
                $variant->product_variant_status     = $request->product_variant_status[$key];
                $variant->product_variant_updated_by  = Auth::guard('admin')->user()->admin_id;
                $variant->product_variant_updated_on  = date('Y-m-d H:i:s');

                if($request->hasFile('product_variant_image'.$key))
                {
                    $product_image = $request->file('product_variant_image'.$key)->store('assets/vendor/uploads/product');
                    $product_image = explode('/',$product_image);
                    $product_image = end($product_image);
                    $variant->product_variant_image = $product_image;
                }

                $variant->save();

            }

            if($update)
            {
                return redirect()->back()->with('success','Product Updated Successfully');
            }
        }
    }

    public function product_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['product_status'] = 2;
        }
        else
        {
            $upd['product_status'] = 1;
        }

        $where['product_id'] = $id;

        $update = Product::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function product_gallery(Request $request)
    {
        $data['product'] = Product::where('product_id',$request->segment(3))->first();

        if(!isset($data['product']))
        {
            return redirect()->route('product');
        }

        $data['set'] = 'product';
        return view('admin.products.product_gallery',$data);
    }

    public function add_product_gallery(Request $request)
    {
        if($request->has('gallery_image'))
        {
            $product = Product::where('product_id',$request->segment(3))->first();

            $old_images = json_decode($product->product_gallery,true);
            $new_images = json_decode($request->gallery_image,true);

            if(!empty($product->product_gallery))
            {
                $images = array_merge($old_images,$new_images);
            }
            else
            {
                $images = $new_images;
            }

            $upd['product_gallery'] = json_encode($images);

            $where['product_id'] = $request->segment(3);
            $update = Product::where($where)->update($upd);

            if($update)
            {
                echo 'success';exit;
            }
        }
    }

    public function drop_image(Request $request)
    {
        if($request->hasFile('file'))
        {
            $file = $request->file->store('assets/admin/uploads/product');

            $file = explode('/',$file);
            $file = end($file);

            echo $file;
        }
    }

    public function remove_image(Request $request)
    {
        $product = Product::where('product_id',$request->segment(3))->first();

        $images = json_decode($product->product_gallery,true);
        $image  = array_search($request->segment(4), $images);
        unset($images[$image]);

        if(!empty($images))
        {
            $upd['product_gallery'] = json_encode($images);
        }
        else
        {
            $upd['product_gallery'] = '';
        }

        Product::where('product_id',$request->segment(3))->update($upd);

        return redirect()->back()->with('success','Image Removed Successfully');
    }

    public function select_attribute(Request $request)
    {
        if($request->ajax())
        {
            $attribute_id = $request->attribute;

            $attributes = AttributeVariation::where(['attribute_variation_attribute'=>$attribute_id,'attribute_variation_trash'=>0])->get();
            if(isset($attributes))
            {
                $data['attributes'] = $attributes;
                $html = '<option value="">Select</option>';
                foreach($attributes as $attribute)
                {
                    $html .='<option value="'.$attribute->attribute_variation_id.'">'.$attribute->attribute_variation_value.'</option>';
                }

            }
            else
            {
                $html = '<option value="">Selet</option>';
            }

            echo $html;

        }
    }

    public function attribute_price(Request $request)
    {
        $attribute_variation_ids = $request->attribute_variation;

        if(str_contains($attribute_variation_ids,','))
        {
            $selected_attri = explode(',',$attribute_variation_ids);
        }
        else
        {
            $selected_attri = [$attribute_variation_ids];
        }

        $attribute_variations = AttributeVariation::getDetails(['attribute_variation_trash'=>0]);
        foreach($attribute_variations as $attribute_variation)
        {
            $att_id[$attribute_variation->attribute_variation_id] = $attribute_variation->attribute_variation_attribute;
            $att_names[$attribute_variation->attribute_variation_id] = $attribute_variation->attribute_name.' - '.$attribute_variation->attribute_variation_value;
            $attri_id[$attribute_variation->attribute_variation_id] = $attribute_variation->attribute_id;
        }

        foreach($selected_attri as $select)
        {
            $att_name[$att_id[$select]][] = $att_names[$select];
            $ids[$attri_id[$select]][] = $select;
        }

        $keys = array_keys($att_name);
        $values = array_values($att_name);
        $value_ids = array_values($ids);

        if(count($values) == 1)
        {
            $combinations = collect($values[0]);
            $combinationIds = collect($value_ids[0]);
        }
        if(count($values) == 2)
        {
            $combinations = collect($values[0])->crossJoin($values[1]);
            $combinationIds = collect($value_ids[0])->crossJoin($value_ids[1]);
        }
        if(count($values) == 3)
        {
            $combinations = collect($values[0])->crossJoin($values[1],$values[2]);
            $combinationIds = collect($value_ids[0])->crossJoin($value_ids[1],$value_ids[2]);
        }
        if(count($values) == 4)
        {
            $combinations = collect($values[0])->crossJoin($values[1],$values[2],$values[3]);
            $combinationIds = collect($value_ids[0])->crossJoin($value_ids[1],$value_ids[2],$value_ids[3]);
        }

        if(count($values) > 1)
        {
            foreach($combinations as $key => $combination)
            {
                $comb[$key] = '';
                for($i=0;$i< count($combination);$i++)
                {
                    $comb[$key] .= ' '.$combination[$i];
                }

            }
            foreach($combinationIds as $key => $comb_id)
            {
                $jsonIds[$key] = json_encode($comb_id);

            }
        }
        else
        {
            $comb = $combinations->toArray();
            $attriIDs = $combinationIds->toArray();
            foreach($attriIDs as $key => $Id)
            {
                $IDS[$key][] = $Id;
            }
            foreach($IDS as $key => $is)
            {
                $jsonIds[$key] = json_encode($is);
            }
        }

        $data['combinations'] = $comb;
        $data['attribute_ids'] = $jsonIds;

        return view('admin.products.attribute_price',$data);

    }

}
