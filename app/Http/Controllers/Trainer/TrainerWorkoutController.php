<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use DB;
use App\Models\Workout;
use App\Models\MuscleGroup;
use App\Models\ExerciseType;
use App\Models\Equipment;
use App\Models\WorkoutCategory;
class TrainerWorkoutController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'workout_plans';
        $data['workout_categories'] = WorkoutCategory::where('workout_category_status',1)->get();
        $data['exercise_types'] = ExerciseType::where('exercise_type_status',1)->get();
        return view('trainer.workouts.workouts',$data);
    }

    public function get_workouts(Request $request)
    {
        if($request->ajax())
        {
            $where['workout_trash'] = 0;
            if(!empty($request->category))
            {
                $where['workout_category'] = $request->category;
            }
            if(!empty($request->type))
            {
                $where['workout_type'] = $request->type;
            }

            $data = Workout::getDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->workout_added_on));

                        return $added_on;
                    })
                    ->addColumn('image',function($row)
                    {
                        if($row->workout_image == NULL)
                        {
                            $image = '<div class="d-flex;align-items-center">
										    <img src="'.asset(config("constants.trainer_path")."images/placeholder.png").'" alt="placeholder" width="37" height="37">
										    <span>'.$row->workout_name.'</span>
										  </div>';
                        }
                        else
                        {
                            $image = '<div class="d-flex;align-items-center">
										    <img src="'.url('assets/trainer/uploads/workout/'.$row->workout_image).'" alt="placeholder" width="37" height="37">
										    <span>'.$row->workout_name.'</span>
										  </div>';
                        }
                        return $image;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('trainer/edit_workout/'.$row->workout_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        // $btn .= '<a href="'.url('trainer/workout_gallery/'.$row->workout_id).'" class="btn btn-icon btn-sm bg-violet text-white" title="Gallery"><i class="fa fa-image"></i></a> ';

                        if($row->workout_status == 1)
                        {
                            $btn .= '<a href="'.url('trainer/workout_status/'.$row->workout_id.'/'.$row->workout_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('trainer/workout_status/'.$row->workout_id.'/'.$row->workout_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_workout(Request $request)
    {
        $data['set'] = 'workout_plans';
        $data['exercise_types'] = ExerciseType::where('exercise_type_status',1)->get();
        $data['muscle_groups'] = MuscleGroup::where('muscle_group_status',1)->get();
        $data['workout_categories'] = WorkoutCategory::where('workout_category_status',1)->get();
        $data['equipments'] = Equipment::where('equipment_status',1)->get();
        return view('trainer.workouts.add_workout',$data);
    }

    public function create_workout(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'workout_name' => 'required',
                       'workout_type' => 'required',
                       'workout_equipment' => 'required',
                       'workout_muscle_group' => 'required',
                       'workout_category' => 'required',];

            $messages = ['workout_name.required'=>'Please enter name',
                        'workout_type.required'=>'Please choose Exercise Type',
                        'workout_equipment.required'=>'Please choose equipment',
                        'workout_muscle_group.required'=>'Please choose muscle group',
                        'workout_category.required'=>'Please choose workout category',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['workout_name'] = $request->workout_name;
            $where['workout_type'] = $request->workout_type;
            $check = Workout::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['workout_name']               = $request->workout_name;
            $ins['workout_type']               = $request->workout_type;
            $ins['workout_equipment']          = $request->workout_equipment;
            $ins['workout_muscle_group']       = $request->workout_muscle_group;
            $ins['workout_other_muscle']       = $request->workout_other_muscle;
            $ins['workout_category']           = $request->workout_category;
            $ins['workout_instruction']        = $request->workout_instruction;
            $ins['workout_vimeo']              = $request->workout_vimeo;
            $ins['workout_youtube']            = $request->workout_youtube;
            $ins['workout_status']             = 1;
            $ins['workout_added_role']         = 3;
            $ins['workout_added_by']           = Auth::guard('trainer')->user()->trainer_id;
            $ins['workout_added_on']           = date('Y-m-d H:i:s');
            $ins['workout_updated_by']         = Auth::guard('trainer')->user()->trainer_id;
            $ins['workout_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('workout_image'))
            {
                $workout_image = $request->workout_image->store('assets/admin/uploads/workout');

                $workout_image = explode('/',$workout_image);
                $workout_image = end($workout_image);
                $ins['workout_image'] = $workout_image;
            }

            $workout_id = Workout::insertGetId($ins);

            if($workout_id)
            {
                return redirect()->back()->with('success','Workout Added Successfully');
            }
        }
    }

    public function edit_workout(Request $request)
    {
        $data['workout'] = $workout = Workout::where('workout_id',$request->segment(3))->first();
        $data['exercise_types'] = ExerciseType::where('exercise_type_status',1)->get();
        $data['muscle_groups'] = MuscleGroup::where('muscle_group_status',1)->get();
        $data['workout_categories'] = WorkoutCategory::where('workout_category_status',1)->get();
        $data['equipments'] = Equipment::where('equipment_status',1)->get();

        if(!isset($data['workout']))
        {
            return redirect('trainer/workout');
        }

        $data['set'] = 'workouts';
        return view('trainer.workouts.edit_workout',$data);
    }

    public function update_workout(Request $request)
    {
        $workout = Workout::where('workout_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
            $rules = [ 'workout_name' => 'required',
                       'workout_type' => 'required',
                       'workout_equipment' => 'required',
                       'workout_muscle_group' => 'required',
                       'workout_category' => 'required',];

            $messages = ['workout_name.required'=>'Please enter name',
                        'workout_type.required'=>'Please choose Exercise Type',
                        'workout_equipment.required'=>'Please choose equipment',
                        'workout_muscle_group.required'=>'Please choose muscle group',
                        'workout_category.required'=>'Please choose workout category',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['workout_name'] = $request->workout_name;
            $where['workout_category'] = $request->workout_category;
            $check_name = Workout::where($where)->where('workout_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['workout_name']               = $request->workout_name;
            $upd['workout_type']               = $request->workout_type;
            $upd['workout_equipment']          = $request->workout_equipment;
            $upd['workout_muscle_group']       = $request->workout_muscle_group;
            $upd['workout_other_muscle']       = $request->workout_other_muscle;
            $upd['workout_category']           = $request->workout_category;
            $upd['workout_instruction']        = $request->workout_instruction;
            $upd['workout_vimeo']              = $request->workout_vimeo;
            $upd['workout_youtube']            = $request->workout_youtube;
            $upd['workout_updated_by']         = Auth::guard('trainer')->user()->trainer_id;
            $upd['workout_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('workout_image'))
            {
                $workout_image = $request->workout_image->store('assets/admin/uploads/workout');

                $workout_image = explode('/',$workout_image);
                $workout_image = end($workout_image);
                $upd['workout_image'] = $workout_image;
            }

            $update = Workout::where('workout_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Workout Updated Successfully');
            }
        }
    }

    public function workout_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['workout_status'] = 2;
        }
        else
        {
            $upd['workout_status'] = 1;
        }

        $where['workout_id'] = $id;

        $update = Workout::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

}
