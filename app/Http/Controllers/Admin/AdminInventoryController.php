<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use App\Models\Inventory;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\ProductVariant;

class AdminInventoryController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'inventory';
        $data['products'] = Product::where('product_status',1)->get();
        $data['vendors'] = Vendor::where('vendor_status',1)->get();
        return view('admin.inventory.inventory',$data);
    }

    public function get_inventory(Request $request)
    {
        if($request->ajax())
        {
            $where['inventory_trash'] = 0;

            if(!empty($request->product))
            {
                $where['product_id'] = $request->product;
            }
            if(!empty($request->vendor))
            {
                $where['product_vendor'] = $request->vendor;
            }

            $data = Inventory::getDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->inventory_added_on));

                        return $added_on;
                    })
                     ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/vendor/uploads/product/'.$row->product_variant_image).'" alt="..." class="avatar-img rounded" height="50">';

                        return $image;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('admin/view_inventory/'.$row->inventory_id).'" class="btn btn-icon btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a> ';

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_stock(Request $request)
    {
        $data['set'] = 'inventory';
        $data['vendors'] = Vendor::where('vendor_status',1)->get();
        return view('admin.inventory.add_stock',$data);
    }

    public function select_product(Request $request)
    {
        if($request->ajax())
        {
            $vendor_id = $request->vendor;

            $products = Product::where(['product_vendor'=>$vendor_id,'product_status'=>1])->get();
            if($products->count() > 0)
            {
                $html = '<option value="">Selet</option>';
                foreach($products as $product)
                {
                    $html .= '<option value="'.$product->product_id.'">'.$product->product_name.'</option>';
                }

            }
            else
            {
                $html = '<option value="">Selet</option>';
            }

            echo $html;

        }
    }

    public function select_variant(Request $request)
    {
        if($request->ajax())
        {
            $product_id = $request->product;

            $variants = ProductVariant::where(['product_variant_product'=>$product_id,'product_variant_status'=>1])->get();
            if($variants->count() > 0)
            {
                $data['variants'] = $variants;
                return view('admin.inventory.variant_table',$data);
            }


        }
    }

    public function create_stock(Request $request)
    {
        if($request->has('submit'))
        {
             $rules = [ 'inventory_vendor' => 'required',
                       'inventory_product' => 'required',];

            $messages = ['inventory_vendor.required'=>'Please choose vendor',
                        'inventory_product.required'=>'Please choose product',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            foreach($request->product_variant_id as $key => $product_variant)
            {
                if($request->inventory_stock[$product_variant] > 0)
                {
                    $variant = ProductVariant::find($product_variant);

                    $insInv['inventory_product']     = $variant->product_variant_product;
                    $insInv['inventory_variant']     = $product_variant;
                    $insInv['inventory_open_stock']  = $variant->product_variant_stock - $variant->product_variant_sale;
                    $insInv['inventory_close_stock'] = $insInv['inventory_open_stock'] + $request->inventory_stock[$product_variant];
                    $insInv['inventory_added_by']    = Auth::guard('admin')->user()->admin_id;
                    $insInv['inventory_added_on	']   = date('Y-m-d H:i:s');
                    $insInv['inventory_updated_by']  = Auth::guard('admin')->user()->admin_id;
                    $insInv['inventory_updated_on']  = date('Y-m-d H:i:s');

                    $inventory = Inventory::create($insInv);

                    $variant->product_variant_stock = $variant->product_variant_stock + $request->inventory_stock[$product_variant];

                    $variant->save();
                }

            }

            return redirect()->back()->with('success','Stock Added Successfully');
        }
    }



}
