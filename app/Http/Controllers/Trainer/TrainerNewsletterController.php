<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\Newsletter;
class TrainerNewsletterController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'newsletters';
        $data['newsletters'] = Newsletter::getDetails(['newsletter_trash'=>0]);
        $data['categories'] = Category::where('category_status',1)->get();
        return view('trainer.newsletters.newsletters',$data);
    }

    public function add_newsletter(Request $request)
    {
        $data['set'] = 'newsletters';
        $data['categories'] = Category::where('category_status',1)->get();
        return view('trainer.newsletters.add_newsletter',$data);
    }

    public function create_newsletter(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'newsletter_title' => 'required',
                       'newsletter_category' => 'required',
                       'newsletter_product' => 'required',];

            $messages = ['newsletter_title.required'=>'Please enter title',
                        'newsletter_category.required'=>'Please choose Category',
                        'newsletter_product.required'=>'Please choose Product',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $ins['newsletter_title']        = $request->newsletter_title;
            $ins['newsletter_date']         = date('d-m-Y');
            $ins['newsletter_description']  = $request->newsletter_description;
            $ins['newsletter_category']    = $request->newsletter_category;
            $ins['newsletter_product']     = $request->newsletter_product;
            $ins['newsletter_audience']    = 1;
            $ins['newsletter_status']      = 1;
            $ins['newsletter_added_by']    = Auth::user()->id;
            $ins['newsletter_added_on']    = date('Y-m-d H:i:s');
            $ins['newsletter_updated_by']  = Auth::user()->id;
            $ins['newsletter_updated_on']  = date('Y-m-d H:i:s');

            if($request->hasFile('newsletter_image'))
            {
                $newsletter_image = $request->newsletter_image->store('assets/trainer/uploads/newsletter');

                $newsletter_image = explode('/',$newsletter_image);
                $newsletter_image = end($newsletter_image);
                $ins['newsletter_image'] = $newsletter_image;
            }

            $newsletter_id = Newsletter::insertGetId($ins);

            if($newsletter_id)
            {
                return redirect()->back()->with('success','Newsletter Added Successfully');
            }
        }
    }

    public function edit_newsletter(Request $request)
    {
        $data['newsletter'] = $newsletter = Newsletter::where('newsletter_id',$request->segment(3))->first();
        $data['categories'] = Category::where('category_status',1)->get();

        if(!isset($data['newsletter']))
        {
            return redirect('trainer/newsletter');
        }

        $data['set'] = 'newsletters';
        return view('trainer.newsletters.edit_newsletter',$data);
    }

    public function update_newsletter(Request $request)
    {
        $newsletter = Newsletter::where('newsletter_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
             $rules = [ 'newsletter_title' => 'required',
                       'newsletter_category' => 'required',
                       'newsletter_product' => 'required',];

            $messages = ['newsletter_title.required'=>'Please enter title',
                        'newsletter_category.required'=>'Please choose Category',
                        'newsletter_product.required'=>'Please choose Product',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['newsletter_name'] = $request->newsletter_name;
            $where['newsletter_category'] = $request->newsletter_category;
            $check_name = Newsletter::where($where)->where('newsletter_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['newsletter_title']        = $request->newsletter_title;
            $upd['newsletter_description']  = $request->newsletter_description;
            $upd['newsletter_category']     = $request->newsletter_category;
            $upd['newsletter_product']      = $request->newsletter_product;
            $upd['newsletter_audience']     = 1;
            $upd['newsletter_updated_by']   = Auth::user()->id;
            $upd['newsletter_updated_on']   = date('Y-m-d H:i:s');

            if($request->hasFile('newsletter_image'))
            {
                $newsletter_image = $request->newsletter_image->store('assets/trainer/uploads/newsletter');

                $newsletter_image = explode('/',$newsletter_image);
                $newsletter_image = end($newsletter_image);
                $upd['newsletter_image'] = $newsletter_image;
            }

            $update = Newsletter::where('newsletter_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Newsletter Updated Successfully');
            }
        }
    }

    public function newsletter_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['newsletter_status'] = 2;
        }
        else
        {
            $upd['newsletter_status'] = 1;
        }

        $where['newsletter_id'] = $id;

        $update = Newsletter::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function newsletter_delete(Request $request)
    {
        $id = $request->segment(3);

        $where['newsletter_id'] = $id;
        $where['newsletter_added_by'] = Auth::user()->id;

        $delete = Newsletter::where($where)->delete();

        if($delete)
        {
            return redirect()->back()->with('success','Newsletter Deleted Successfully');
        }
    }

    public function view_exercise(Request $request)
    {
        $newsletter_id = $request->exercise;

        $data['newsletter_detail'] = Newsletter::getDetails(['newsletter_id'=>$newsletter_id])->first();

        return view('trainer.newsletters.view_newsletter',$data);

    }

    public function filter_newsletter(Request $request)
    {
        $where['newsletter_status'] = 1;
        if($request->category != '')
        {
            $where['newsletter_category'] = $request->category;
        }
        if($request->product != '')
        {
            $where['newsletter_product'] = $request->product;
        }

        $data['newsletters'] = Newsletter::getDetails($where);

        return view('trainer.newsletters.newsletter_list',$data);

    }

    public function select_product(Request $request)
    {
        if($request->ajax())
        {
            $category = $request->category;

            $products = Product::where(['product_category'=>$category,'product_added_by'=>Auth::user()->id])->get();
            $html = '<option value="">Selet</option>';
            if(isset($products))
            {
                foreach($products as $product)
                {
                    $html .= '<option value="'.$product->product_id.'">'.$product->product_name.'</option>';
                }
            }
            echo $html;
        }
    }

}
