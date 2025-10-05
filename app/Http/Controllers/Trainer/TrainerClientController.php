<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use DB;
use App\Models\Client;
use App\Models\ClientMeasurement;
use App\Models\Category;

class TrainerClientController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'clients';
        return view('trainer.client.clients',$data);
    }

    public function get_clients(Request $request)
    {
        if($request->ajax())
        {
            $data = Client::getClientTrainer(['trainer_client_trainer'=>Auth::guard('trainer')->user()->trainer_id]);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->client_added_on));

                        return $added_on;
                    })
                    ->addColumn('image', function($row){

                        $image = '<img src="'.url('assets/trainer/uploads/client/'.$row->client_image).'" alt="..." class="avatar-img rounded" width="50">';

                        return $image;
                    })
                    ->addColumn('status', function($row)
                    {
                        if($row->client_status == 1)
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

                        $btn = '<a href="'.url('trainer/view_client/'.$row->client_id).'" class="btn btn-icon btn-sm btn-success" title="View"><i class="fa fa-eye"></i></a> ';

                        $btn .= '<a href="'.url('trainer/edit_client/'.$row->client_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->client_status == 1)
                        {
                            $btn .= '<a href="'.url('trainer/client_status/'.$row->client_id.'/'.$row->client_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('trainer/client_status/'.$row->client_id.'/'.$row->client_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_client(Request $request)
    {
        $data['set'] = 'clients';
        $data['categories'] = Category::where('category_status',1)->get();
        return view('trainer.client.add_client',$data);
    }

    public function create_client(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['client_email'=>'required',
                       'client_name' => 'required',
                       'client_phone' => 'required'];

            $messages = ['client_email.required'=>'Please Enter Email',
                        'client_email.email'=>'Please Enter Valid Email',
                        'client_name.required'=>'Please enter name',
                        'client_phone.required'=>'Please enter phone'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['client_email'] = $request->client_email;
            $check_name = Client::where($where_name)->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Email already in use')->withInput();
            }

            $ins['client_name']       = $request->client_name;
            $ins['client_email']      = $request->client_email;
            $ins['client_phone']      = $request->client_phone;
            $ins['client_password']   = bcrypt($request->client_password);
            $ins['client_vpassword']  = base64_encode($request->client_password);
            $ins['client_status']     = 1;
            $ins['client_added_by']   = Auth::guard('trainer')->user()->trainer_id;
            $ins['client_added_on']   = date('Y-m-d H:i:s');
            $ins['client_updated_by'] = Auth::guard('trainer')->user()->trainer_id;
            $ins['client_updated_on'] = date('Y-m-d H:i:s');
            if($request->hasFile('client_image'))
            {
                $client_image = $request->client_image->store('assets/client/uploads/profile');

                $client_image = explode('/',$client_image);
                $client_image = end($client_image);
                $ins['client_image'] = $client_image;
            }

            $insert_id = Client::insertGetId($ins);

            if($insert_id)
            {
                $ins_client['trainer_client'] = $insert_id;
                $ins_client['trainer_client_trainer'] = Auth::guard('trainer')->user()->trainer_id;

                DB::table('trainer_clients')->insert($ins_client);

                return redirect()->back()->with('success','Client Added Successfully');
            }
        }
    }

    public function view_client(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();
        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'overview';
        return view('trainer.client.view_client',$data);
    }

    public function client_workout_plan(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'workout_plan';
        return view('trainer.client.client_workout_plan',$data);
    }

    public function client_exercise_statics(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'exercise_statics';
        return view('trainer.client.client_exercise_statics',$data);
    }

    public function client_advanced_statics(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'advanced_statics';
        return view('trainer.client.client_advanced_statics',$data);
    }

    public function client_body_measurement(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();
        $data['body_parts'] = DB::table('body_parts')->where('body_part_status',1)->get();
        $data['measurements'] = $measurements = ClientMeasurement::where(['client_measurement_part'=>1,'client_measurement_client'=>$request->segment(3)])->orderby('client_measurement_date','desc')->get();
        $measurements = ClientMeasurement::where(['client_measurement_part'=>1,'client_measurement_client'=>$request->segment(3)])->orderby('client_measurement_date','asc')->get();
        $values = array();
        $dates = array();
        if( $measurements->count() > 0)
        {
            foreach($measurements as $measurement)
            {
                $values[] = (int)str_replace(' cm',"",$measurement->client_measurement);
                $dates[] = date('M d',strtotime($measurement->client_measurement_date));
            }
        }

        $data['y'] = $values;
        $data['x'] = $dates;

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'body_measurement';
        return view('trainer.client.client_body_measurements',$data);
    }

    public function client_progress_picture(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'progress_picture';
        return view('trainer.client.client_progress_picture',$data);
    }

    public function client_settings(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'client_settings';
        return view('trainer.client.client_settings',$data);
    }

    public function client_goals(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        $data['sub_set'] = 'client_goals';
        return view('trainer.client.client_goals',$data);
    }

    public function edit_client(Request $request)
    {
        $data['client'] = Client::where('client_id',$request->segment(3))->first();

        if(!isset($data['client']))
        {
            return redirect('trainer/clients');
        }

        $data['set'] = 'clients';
        return view('trainer.client.edit_client',$data);
    }

    public function update_client(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['client_email'=>'required',
                       'client_name' => 'required',
                       'client_phone' => 'required'];

            $messages = ['client_email.required'=>'Please Enter Email',
                        'client_email.email'=>'Please Enter Valid Email',
                        'client_name.required'=>'Please enter name',
                        'client_phone.required'=>'Please enter phone'];


            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where_name['client_email'] = $request->client_email;
            $check_name = Client::where($where_name)->where('client_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Email already in use')->withInput();
            }

            $upd['client_name']       = $request->client_name;
            $upd['client_email']      = $request->client_email;
            $upd['client_phone']      = $request->client_phone;
            $upd['client_updated_by'] = Auth::guard('trainer')->user()->trainer_id;
            $upd['client_updated_on'] = date('Y-m-d H:i:s');
            if($request->client_password != NULL)
            {
                $upd['client_password']   = bcrypt($request->client_password);
                $upd['client_vpassword']   = base64encode($request->client_password);
            }

            if($request->hasFile('client_image'))
            {
                $client_image = $request->client_image->store('assets/client/uploads/profile');

                $client_image = explode('/',$client_image);
                $client_image = end($client_image);
                $upd['client_image'] = $client_image;
            }

            $update = Client::where('client_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Client Updated Successfully');
            }
        }
    }

    public function client_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['client_status'] = 2;
        }
        else
        {
            $upd['client_status'] = 1;
        }

        $where['client_id'] = $id;

        $update = Client::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }


    public function client_delete(Request $request)
    {
        $id = $request->segment(3);

        $upd['client_trash'] = 1;

        $where['client_id'] = $id;

        $update = Client::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Deleted Successfully');
        }
    }

    public function client_measurement(Request $request)
    {
        $data['body_parts'] = DB::table('body_parts')->where('body_part_id',$request->body_part)->first();
        $data['measurements'] = $measurements = ClientMeasurement::where(['client_measurement_part'=>$request->body_part,'client_measurement_client'=>$request->client])->orderby('client_measurement_date','desc')->get();
        $measurements = ClientMeasurement::where(['client_measurement_part'=>$request->body_part,'client_measurement_client'=>$request->client])->orderby('client_measurement_date','asc')->get();

        $values = array();
        $dates = array();
        if( $measurements->count() > 0)
        {
            foreach($measurements as $measurement)
            {
                $values[] = (int)str_replace(' cm',"",$measurement->client_measurement);
                $dates[] = date('M d',strtotime($measurement->client_measurement_date));
            }
        }

        $data['y'] = $values;
        $data['x'] = $dates;

        return view('trainer.client.client_body_details',$data);
    }

    public function add_measurement_log(Request $request)
    {
        $ins['client_measurement_part']       = $request->client_measurement_part;
        $ins['client_measurement']            = $request->client_measurement;
        $ins['client_measurement_date']       = $request->client_measurement_date;
        $ins['client_measurement_client']     = $request->client;
        $ins['client_measurement_status']     = 1;
        $ins['client_measurement_added_by']   = Auth::guard('trainer')->user()->trainer_id;
        $ins['client_measurement_added_on']   = date('Y-m-d H:i:s');
        $ins['client_measurement_updated_by'] = Auth::guard('trainer')->user()->trainer_id;
        $ins['client_measurement_updated_on'] = date('Y-m-d H:i:s');

        $insert_id = ClientMeasurement::insertGetId($ins);

        if($insert_id)
        {
            $data['status'] = 1;
            echo json_encode($data);
        }
    }

}
