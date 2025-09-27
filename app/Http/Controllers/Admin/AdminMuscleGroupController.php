<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MuscleGroup;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;

class AdminMuscleGroupController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'muscle_group';
        return view('admin.muscle_group.muscle_groups',$data);
    }

    public function add_muscle_group(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['muscle_group_name' => 'required'
                      ];

            $messages = ['muscle_group_name.required' => 'Please Enter Name'
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_name['muscle_group_name'] = $request->muscle_group_name;
                $check_name = MuscleGroup::where($where_name)->count();

                if($check_name > 0)
                {
                    return redirect()->back()->with('error','Name already in use')->withInput();
                }

                $ins['muscle_group_name']       = $request->muscle_group_name;
                $ins['muscle_group_status']     = 1;
                $ins['muscle_group_added_on']   = date('Y-m-d H:i:s');
                $ins['muscle_group_added_by']   = 0;
                $ins['muscle_group_updated_on'] = date('Y-m-d H:i:s');
                $ins['muscle_group_updated_by'] = 0;

                if($request->hasFile('muscle_group_image'))
                {
                    $muscle_group_image = $request->muscle_group_image->store('assets/admin/uploads/muscle_group');

                    $muscle_group_image = explode('/',$muscle_group_image);
                    $muscle_group_image = end($muscle_group_image);
                    $ins['muscle_group_image'] = $muscle_group_image;
                }

                $insert = MuscleGroup::create($ins);

                if($insert)
                {
                    return redirect()->back()->with('success','Muscle Group Added Successfully');
                }
            }
        }
    }

    public function muscle_group_detail(Request $request)
    {
        if($request->ajax())
        {
            $muscle_group_id = $request->muscle_group_id;

            $muscle_group = MuscleGroup::where('muscle_group_id',$muscle_group_id)->first()->toArray();
            if(isset($muscle_group))
            {
                $data['error'] = 0;
                $data['name'] = $muscle_group['muscle_group_name'];
            }
            else
            {
                $data['error'] = 0;
            }

            echo json_encode($data);

        }
    }

    public function edit_muscle_group(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['muscle_group_name' => 'required'
                      ];

            $messages = ['muscle_group_name.required' => 'Please Enter Name'
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_name['muscle_group_name'] = $request->muscle_group_name;
                $check_name = MuscleGroup::where($where_name)->where('muscle_group_id','!=',$request->muscle_group_id)->count();

                if($check_name > 0)
                {
                    return redirect()->back()->with('error','Name already in use')->withInput();
                }

                $upd['muscle_group_name']       = $request->muscle_group_name;
                $upd['muscle_group_updated_on'] = date('Y-m-d H:i:s');
                $upd['muscle_group_updated_by'] = 0;

                if($request->hasFile('muscle_group_image'))
                {
                    $muscle_group_image = $request->muscle_group_image->store('assets/admin/uploads/muscle_group');

                    $muscle_group_image = explode('/',$muscle_group_image);
                    $muscle_group_image = end($muscle_group_image);
                    $upd['muscle_group_image'] = $muscle_group_image;
                }

                $update = MuscleGroup::where('muscle_group_id',$request->muscle_group_id)->update($upd);

                if($update)
                {
                    return redirect()->back()->with('success','Muscle Group Updated Successfully');
                }
            }
        }
    }

    public function muscle_group_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['muscle_group_status'] = 2;
        }
        else
        {
            $upd['muscle_group_status'] = 1;
        }

        $where['muscle_group_id'] = $id;

        $update = MuscleGroup::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function get_muscle_group(Request $request)
    {
        if($request->ajax())
        {
            $data = MuscleGroup::orderby('muscle_group_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->muscle_group_added_on));

                        return $added_on;
                    })
                     ->addColumn('status', function($row)
                    {
                        if($row->muscle_group_status == 1)
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

                        $btn = '<button class="btn btn-icon btn-sm btn-info" onclick="edit_muscle_group('.$row->muscle_group_id.')" title="Edit"><i class="ti ti-edit"></i></button> ';

                        if($row->muscle_group_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/muscle_group_status/'.$row->muscle_group_id.'/'.$row->muscle_group_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="ti ti-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/muscle_group_status/'.$row->muscle_group_id.'/'.$row->muscle_group_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="ti ti-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
    }

}
