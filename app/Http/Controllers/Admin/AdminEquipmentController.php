<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;

class AdminEquipmentController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'equipment';
        return view('admin.equipment.equipments',$data);
    }

    public function add_equipment(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['equipment_name' => 'required'
                      ];

            $messages = ['equipment_name.required' => 'Please Enter Name'
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_name['equipment_name'] = $request->equipment_name;
                $check_name = Equipment::where($where_name)->count();

                if($check_name > 0)
                {
                    return redirect()->back()->with('error','Name already in use')->withInput();
                }

                $ins['equipment_name']       = $request->equipment_name;
                $ins['equipment_status']     = 1;
                $ins['equipment_added_on']   = date('Y-m-d H:i:s');
                $ins['equipment_added_by']   = 0;
                $ins['equipment_updated_on'] = date('Y-m-d H:i:s');
                $ins['equipment_updated_by'] = 0;

                if($request->hasFile('equipment_image'))
                {
                    $equipment_image = $request->equipment_image->store('assets/admin/uploads/equipment');

                    $equipment_image = explode('/',$equipment_image);
                    $equipment_image = end($equipment_image);
                    $ins['equipment_image'] = $equipment_image;
                }

                $insert = Equipment::create($ins);

                if($insert)
                {
                    return redirect()->back()->with('success','Exercise Type Added Successfully');
                }
            }
        }
    }

    public function equipment_detail(Request $request)
    {
        if($request->ajax())
        {
            $equipment_id = $request->equipment_id;

            $equipment = Equipment::where('equipment_id',$equipment_id)->first()->toArray();
            if(isset($equipment))
            {
                $data['error'] = 0;
                $data['name'] = $equipment['equipment_name'];
            }
            else
            {
                $data['error'] = 0;
            }

            echo json_encode($data);

        }
    }

    public function edit_equipment(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = ['equipment_name' => 'required'
                      ];

            $messages = ['equipment_name.required' => 'Please Enter Name'
                        ];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where_name['equipment_name'] = $request->equipment_name;
                $check_name = Equipment::where($where_name)->where('equipment_id','!=',$request->equipment_id)->count();

                if($check_name > 0)
                {
                    return redirect()->back()->with('error','Name already in use')->withInput();
                }

                $upd['equipment_name']       = $request->equipment_name;
                $upd['equipment_updated_on'] = date('Y-m-d H:i:s');
                $upd['equipment_updated_by'] = 0;

                if($request->hasFile('equipment_image'))
                {
                    $equipment_image = $request->equipment_image->store('assets/admin/uploads/equipment');

                    $equipment_image = explode('/',$equipment_image);
                    $equipment_image = end($equipment_image);
                    $upd['equipment_image'] = $equipment_image;
                }

                $update = Equipment::where('equipment_id',$request->equipment_id)->update($upd);

                if($update)
                {
                    return redirect()->back()->with('success','Exercise Type Updated Successfully');
                }
            }
        }
    }

    public function equipment_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['equipment_status'] = 2;
        }
        else
        {
            $upd['equipment_status'] = 1;
        }

        $where['equipment_id'] = $id;

        $update = Equipment::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function get_equipment(Request $request)
    {
        if($request->ajax())
        {
            $data = Equipment::orderby('equipment_id','asc')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->equipment_added_on));

                        return $added_on;
                    })
                     ->addColumn('status', function($row)
                    {
                        if($row->equipment_status == 1)
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

                        $btn = '<button class="btn btn-icon btn-sm btn-info" onclick="edit_equipment('.$row->equipment_id.')" title="Edit"><i class="ti ti-edit"></i></button> ';

                        if($row->equipment_status == 1)
                        {
                            $btn .= '<a href="'.url('admin/equipment_status/'.$row->equipment_id.'/'.$row->equipment_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="ti ti-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('admin/equipment_status/'.$row->equipment_id.'/'.$row->equipment_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="ti ti-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
    }

}
