<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExerciseType;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;

class AdminExerciseTypeController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'exercise_type';
        return view('admin.exercise_type.exercise_types',$data);
    }

    public function add_exercise_type(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['exercise_type_name' => 'required'
                      ];

            $messages = ['exercise_type_name.required' => 'Please Enter Name'
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_name['exercise_type_name'] = $request->exercise_type_name;
                $check_name = ExerciseType::where($where_name)->count();

                if($check_name > 0)
                {
                    return redirect()->back()->with('error','Name already in use')->withInput();
                }

                $ins['exercise_type_name']       = $request->exercise_type_name;
                $ins['exercise_type_status']     = 1;
                $ins['exercise_type_added_on']   = date('Y-m-d H:i:s');
                $ins['exercise_type_added_by']   = 0;
                $ins['exercise_type_updated_on'] = date('Y-m-d H:i:s');
                $ins['exercise_type_updated_by'] = 0;

                if($request->hasFile('exercise_type_image'))
                {
                    $exercise_type_image = $request->exercise_type_image->store('assets/admin/uploads/exercise_type');

                    $exercise_type_image = explode('/',$exercise_type_image);
                    $exercise_type_image = end($exercise_type_image);
                    $ins['exercise_type_image'] = $exercise_type_image;
                }

                $insert = ExerciseType::create($ins);

                if($insert)
                {
                    return redirect()->back()->with('success','Muscle Group Added Successfully');
                }
            }
        }
    }

    public function exercise_type_detail(Request $request)
    {
        if($request->ajax())
        {
            $exercise_type_id = $request->exercise_type_id;

            $exercise_type = ExerciseType::where('exercise_type_id',$exercise_type_id)->first()->toArray();
            if(isset($exercise_type))
            {
                $data['error'] = 0;
                $data['name'] = $exercise_type['exercise_type_name'];
            }
            else
            {
                $data['error'] = 0;
            }

            echo json_encode($data);

        }
    }

    public function edit_exercise_type(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['exercise_type_name' => 'required'
                      ];

            $messages = ['exercise_type_name.required' => 'Please Enter Name'
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_name['exercise_type_name'] = $request->exercise_type_name;
                $check_name = ExerciseType::where($where_name)->where('exercise_type_id','!=',$request->exercise_type_id)->count();

                if($check_name > 0)
                {
                    return redirect()->back()->with('error','Name already in use')->withInput();
                }

                $upd['exercise_type_name']       = $request->exercise_type_name;
                $upd['exercise_type_updated_on'] = date('Y-m-d H:i:s');
                $upd['exercise_type_updated_by'] = 0;

                if($request->hasFile('exercise_type_image'))
                {
                    $exercise_type_image = $request->exercise_type_image->store('assets/admin/uploads/exercise_type');

                    $exercise_type_image = explode('/',$exercise_type_image);
                    $exercise_type_image = end($exercise_type_image);
                    $upd['exercise_type_image'] = $exercise_type_image;
                }

                $update = ExerciseType::where('exercise_type_id',$request->exercise_type_id)->update($upd);

                if($update)
                {
                    return redirect()->back()->with('success','Muscle Group Updated Successfully');
                }
            }
        }
    }

    public function exercise_type_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['exercise_type_status'] = 2;
        }
        else
        {
            $upd['exercise_type_status'] = 1;
        }

        $where['exercise_type_id'] = $id;

        $update = ExerciseType::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function get_exercise_type(Request $request)
    {
        if($request->ajax())
        {
            $data = ExerciseType::orderby('exercise_type_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->exercise_type_added_on));

                        return $added_on;
                    })
                     ->addColumn('status', function($row)
                    {
                        if($row->exercise_type_status == 1)
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

                        $btn = '<button class="btn btn-icon btn-sm btn-info" onclick="edit_exercise_type('.$row->exercise_type_id.')" title="Edit"><i class="ti ti-edit"></i></button> ';

                        if($row->exercise_type_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/exercise_type_status/'.$row->exercise_type_id.'/'.$row->exercise_type_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="ti ti-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/exercise_type_status/'.$row->exercise_type_id.'/'.$row->exercise_type_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="ti ti-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
    }

}
