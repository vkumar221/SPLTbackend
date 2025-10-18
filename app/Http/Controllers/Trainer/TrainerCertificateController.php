<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use DB;
use App\Models\TrainerCertificate;
class TrainerCertificateController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'certificates';
        return view('trainer.certificates.certificates',$data);
    }

    public function get_certificates(Request $request)
    {
        if($request->ajax())
        {
            $where['certificate_trash'] = 0;
            $where['certificate_added_by'] = Auth::user()->id;

            $data = TrainerCertificate::getDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->certificate_added_on));

                        return $added_on;
                    })
                    ->addColumn('image',function($row)
                    {
                        if($row->certificate_image == NULL)
                        {
                            $image = '<div class="d-flex;align-items-center">
										    <img src="'.asset(config("constants.trainer_path")."images/placeholder.png").'" alt="placeholder" width="37" height="37">
										  </div>';
                        }
                        else
                        {
                            $image = '<div class="d-flex;align-items-center">
										    <img src="'.url('assets/trainer/uploads/certificate/'.$row->certificate_image).'" alt="placeholder" width="37" height="37">
										  </div>';
                        }
                        return $image;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('trainer/edit_certificate/'.$row->certificate_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->certificate_status == 1)
                        {
                            $btn .= '<a href="'.url('trainer/certificate_status/'.$row->certificate_id.'/'.$row->certificate_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('trainer/certificate_status/'.$row->certificate_id.'/'.$row->certificate_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_certificate(Request $request)
    {
        $data['set'] = 'certificates';
        return view('trainer.certificates.add_certificate',$data);
    }

    public function create_certificate(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'certificate_title' => 'required',
                       'certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,max_width=1000,min_height=200,max_height=1000',];

            $messages = ['certificate_title.required'=>'Please enter title',
                        'certificate_image.required'=>'Please choose Image'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['certificate_title'] = $request->certificate_title;
            $check = TrainerCertificate::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Title already in use')->withInput();
            }

            $ins['certificate_title']               = $request->certificate_title;
            $ins['certificate_status']             = 1;
            $ins['certificate_added_by']           = Auth::user()->id;
            $ins['certificate_added_on']           = date('Y-m-d H:i:s');
            $ins['certificate_updated_by']         = Auth::user()->id;
            $ins['certificate_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('certificate_image'))
            {
                $certificate_image = $request->certificate_image->store('assets/trainer/uploads/certificate');

                $certificate_image = explode('/',$certificate_image);
                $certificate_image = end($certificate_image);
                $ins['certificate_image'] = $certificate_image;
            }

            $certificate_id = TrainerCertificate::insertGetId($ins);

            if($certificate_id)
            {
                return redirect()->back()->with('success','Certificate Added Successfully');
            }
        }
    }

    public function edit_certificate(Request $request)
    {
        $data['certificate'] = $certificate = TrainerCertificate::where('certificate_id',$request->segment(3))->first();

        if(!isset($data['certificate']))
        {
            return redirect('trainer/certificate');
        }

        $data['set'] = 'certificates';
        return view('trainer.certificates.edit_certificate',$data);
    }

    public function update_certificate(Request $request)
    {
        $certificate = TrainerCertificate::where('certificate_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
             $rules = [ 'certificate_title' => 'required',
                       'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,max_width=1000,min_height=200,max_height=1000',];

            $messages = ['certificate_title.required'=>'Please enter title'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['certificate_title'] = $request->certificate_title;
            $check_name = TrainerCertificate::where($where)->where('certificate_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Title already in use')->withInput();
            }

            $upd['certificate_title']               = $request->certificate_title;
            $upd['certificate_updated_by']         = Auth::user()->id;
            $upd['certificate_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('certificate_image'))
            {
                $certificate_image = $request->certificate_image->store('assets/trainer/uploads/certificate');

                $certificate_image = explode('/',$certificate_image);
                $certificate_image = end($certificate_image);
                $upd['certificate_image'] = $certificate_image;
            }

            $update = TrainerCertificate::where('certificate_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Certificate Updated Successfully');
            }
        }
    }

    public function certificate_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['certificate_status'] = 2;
        }
        else
        {
            $upd['certificate_status'] = 1;
        }

        $where['certificate_id'] = $id;

        $update = TrainerCertificate::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

}
