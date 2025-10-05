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
use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanExercise;
use App\Models\WorkoutCategory;
use App\Models\MuscleGroup;
use App\Models\ExerciseType;
use App\Models\Equipment;
class TrainerWorkoutPlanController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'workout_plans';
        $data['workout_categories'] = WorkoutCategory::where('workout_category_status',1)->get();
        $data['my_workout_plans'] = WorkoutPlan::getPlanTrainer(['trainer_workout_trainer'=>Auth::guard('trainer')->user()->trainer_id]);
        $exercises = WorkoutPlanExercise::get();
        if($exercises->count() > 0)
        {
            foreach($exercises as $exercise)
            {
                $workout[$exercise->workout_plan_plan][] = $exercise->workout_plan_exercise_id;
            }
            $data['excersises'] = $workout;
        }
        return view('trainer.workout_plans.workout_plans',$data);
    }

    public function split(Request $request)
    {
        $data['set'] = 'workout_plans';
        $data['workout_categories'] = WorkoutCategory::where('workout_category_status',1)->get();
        $data['workout_plans'] = WorkoutPlan::getDetails(['workout_plan_added_role'=>1,'workout_plan_status'=>1]);
        return view('trainer.workout_plans.workout_plan_split',$data);
    }

    public function get_workout_plans(Request $request)
    {
        if($request->ajax())
        {
            $where['workout_plan_trash'] = 0;
            if(!empty($request->category))
            {
                $where['workout_plan_category'] = $request->category;
            }

            $data = WorkoutPlan::getDetails($where);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('added_on', function($row){

                        $added_on = date('d-M-y',strtotime($row->workout_plan_added_on));

                        return $added_on;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.url('trainer/edit_workout_plan/'.$row->workout_plan_id).'" class="btn btn-icon btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';

                        if($row->workout_plan_status == 1)
                        {
                            $btn .= '<a href="'.url('trainer/workout_plan_status/'.$row->workout_plan_id.'/'.$row->workout_plan_status).'" class="btn btn-icon btn-sm btn-warning" title="Click to disable" onclick="confirm_msg(event)"><i class="fa fa-ban"></i></a> ';
                        }
                        else
                        {
                            $btn .= '<a href="'.url('trainer/workout_plan_status/'.$row->workout_plan_id.'/'.$row->workout_plan_status).'" class="btn btn-icon btn-sm btn-success" title="Click to enable" onclick="confirm_msg(event)"><i class="fa fa-check"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','status'])
                    ->make(true);
        }
    }

    public function add_workout_plan(Request $request)
    {
        $data['set'] = 'workout_plans';
        $data['workout_categories'] = WorkoutCategory::where('workout_category_status',1)->get();
        $data['exercise_types'] = ExerciseType::where('exercise_type_status',1)->get();
        $data['muscle_groups'] = MuscleGroup::where('muscle_group_status',1)->get();
        $data['equipments'] = Equipment::where('equipment_status',1)->get();
        $data['workouts'] = Workout::getDetails(['workout_status'=>1]);
        return view('trainer.workout_plans.add_workout_plan',$data);
    }

    public function create_workout_plan(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'workout_plan_name' => 'required',
                       'workout_plan_duration' => 'required',
                       'workout_plan_category' => 'required',];

            $messages = ['workout_plan_name.required'=>'Please enter name',
                        'workout_plan_duration.required'=>'Please enter workout plan',
                        'workout_plan_category.required'=>'Please choose workout plan category',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                print_r($validator->errors());exit;
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['workout_plan_name'] = $request->workout_plan_name;
            $where['workout_plan_category'] = $request->workout_plan_category;
            $check = WorkoutPlan::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $ins['workout_plan_name']          = $request->workout_plan_name;
            $ins['workout_plan_duration']      = $request->workout_plan_duration;
            $ins['workout_plan_category']      = $request->workout_plan_category;
            $ins['workout_plan_note']          = $request->workout_plan_note;
            $ins['workout_plan_goal']          = $request->workout_plan_goal;
            $ins['workout_plan_days']          = $request->workout_plan_days;
            $ins['workout_plan_status']        = 1;
            $ins['workout_plan_added_role']    = 3;
            $ins['workout_plan_added_by']      = Auth::guard('trainer')->user()->trainer_id;
            $ins['workout_plan_added_on']      = date('Y-m-d H:i:s');
            $ins['workout_plan_updated_by']    = Auth::guard('trainer')->user()->trainer_id;
            $ins['workout_plan_updated_on']    = date('Y-m-d H:i:s');

            $workout_plan_id = WorkoutPlan::insertGetId($ins);

            $exercises = explode(',',$request->exercises);

            foreach($exercises as $key => $exercise)
            {
                if($exercise != NULL)
                {
                    $insEx['workout_plan_exercise']  = $exercise;
                    $insEx['workout_plan_plan']      = $workout_plan_id;
                    $insEx['workout_plan_exercise_sets']  = $request->workout_plan_exercise_sets[$exercise];
                    $insEx['workout_plan_exercise_reps']   = $request->workout_plan_exercise_reps[$exercise];

                    WorkoutPlanExercise::create($insEx);
                }
            }

            if($workout_plan_id)
            {
                $trn_plan['trainer_workout_plan'] = $workout_plan_id;
                $trn_plan['trainer_workout_trainer'] = Auth::guard('trainer')->user()->trainer_id;

                DB::table('trainer_workout_plans')->insert($trn_plan);

                return redirect()->back()->with('success','Workout Added Successfully');
            }
        }
    }

    public function edit_workout_plan(Request $request)
    {
        $data['workout_plan'] = $workout_plan = WorkoutPlan::where('workout_plan_id',$request->segment(3))->first();
        $data['workout_categories'] = WorkoutCategory::where('workout_category_status',1)->get();
        $data['exercise_types'] = ExerciseType::where('exercise_type_status',1)->get();
        $data['muscle_groups'] = MuscleGroup::where('muscle_group_status',1)->get();
        $data['equipments'] = Equipment::where('equipment_status',1)->get();
        $data['excercises'] = WorkoutPlanExercise::getDetails(['workout_plan_plan'=>$request->segment(3)]);
        $exclude = WorkoutPlanExercise::where('workout_plan_plan', $request->segment(3))->pluck('workout_plan_exercise');
        $data['exercise_value'] = $exclude->implode(',');
        $where['workout_status'] = 1;
        $data['workouts'] = Workout::getDetailFilter($where,$exclude);


        if(!isset($data['workout_plan']))
        {
            return redirect('trainer/workout_plan');
        }

        $data['set'] = 'workout_plans';
        return view('trainer.workout_plans.edit_workout_plan',$data);
    }

    public function update_workout_plan(Request $request)
    {
        $workout_plan = WorkoutPlan::where('workout_plan_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
            $rules = [ 'workout_plan_name' => 'required',
                       'workout_plan_duration' => 'required',
                       'workout_plan_category' => 'required',];

            $messages = ['workout_plan_name.required'=>'Please enter name',
                        'workout_plan_duration.required'=>'Please enter workout plan',
                        'workout_plan_category.required'=>'Please choose workout plan category',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['workout_plan_name'] = $request->workout_plan_name;
            $where['workout_plan_category'] = $request->workout_plan_category;
            $check_name = WorkoutPlan::where($where)->where('workout_plan_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Name already in use')->withInput();
            }

            $upd['workout_plan_name']          = $request->workout_plan_name;
            $upd['workout_plan_duration']      = $request->workout_plan_duration;
            $upd['workout_plan_category']      = $request->workout_plan_category;
            $upd['workout_plan_note']          = $request->workout_plan_note;
            $upd['workout_plan_goal']          = $request->workout_plan_goal;
            $upd['workout_plan_days']          = $request->workout_plan_days;
            $upd['workout_plan_updated_by']    = Auth::guard('trainer')->user()->trainer_id;
            $upd['workout_plan_updated_on']    = date('Y-m-d H:i:s');

            $update = WorkoutPlan::where('workout_plan_id',$request->segment(3))->update($upd);

            WorkoutPlanExercise::where('workout_plan_plan',$request->segment(3))->delete();

            $exercises = explode(',',$request->exercises);
            foreach($exercises as $key => $exercise)
            {
                if($exercise != NULL)
                {
                    $insEx['workout_plan_exercise']  = $exercise;
                    $insEx['workout_plan_plan']      = $request->segment(3);
                    $insEx['workout_plan_exercise_sets']  = $request->workout_plan_exercise_sets[$exercise];
                    $insEx['workout_plan_exercise_reps']   = $request->workout_plan_exercise_reps[$exercise];

                    WorkoutPlanExercise::create($insEx);
                }
            }

            if($update)
            {
                return redirect()->back()->with('success','Workout Plan Updated Successfully');
            }
        }
    }

    public function workout_plan_status(Request $request)
    {
        $id = $request->segment(3);
        $status = $request->segment(4);

        if($status == 1)
        {
            $upd['workout_plan_status'] = 2;
        }
        else
        {
            $upd['workout_plan_status'] = 1;
        }

        $where['workout_plan_id'] = $id;

        $update = WorkoutPlan::where($where)->update($upd);

        if($update)
        {
            return redirect()->back()->with('success','Status Changed Successfully');
        }
    }

    public function add_to_plan(Request $request)
    {
        $exercises = explode(',',$request->exercises);

        $data['excercises'] = Workout::getDetailWherein($exercises);

        return view('trainer.workout_plans.workout_selected',$data);

    }

    public function filter_workout(Request $request)
    {
        if($request->exercises != '')
        {
            $exercises = explode(',',$request->exercises);
        }
        else
        {
            $exercises = '';
        }

        $where['workout_status'] = 1;
        if($request->exercise_type != '')
        {
            $where['workout_type'] = $request->exercise_type;
        }
        if($request->equipment != '')
        {
            $where['workout_equipment'] = $request->equipment;
        }
        if($request->muscle_group != '')
        {
            $where['workout_muscle_group'] = $request->muscle_group;
        }

        $data['excercises'] = Workout::getDetailFilter($where,$exercises);

        return view('trainer.workout_plans.workout_list',$data);

    }

    public function get_programs(Request $request)
    {
        $where['workout_plan_status'] = 1;
        $where['workout_plan_added_role'] = 1;

        if($request->category != 0)
        {
            $where['workout_plan_category'] = $request->category;
        }

        $data['workout_plans'] = WorkoutPlan::getDetails($where);

        return view('trainer.workout_plans.workout_plan_list',$data);

    }

    public function add_library(Request $request)
    {
        $id = $request->segment(3);

        $check = DB::table('trainer_workout_plans')->where(['trainer_workout_plan'=>$id,'trainer_workout_trainer'=>Auth::guard('trainer')->user()->trainer_id])->count();

        if($check == 0)
        {
            DB::table('trainer_workout_plans')->insert(['trainer_workout_plan'=>$id,'trainer_workout_trainer'=>Auth::guard('trainer')->user()->trainer_id]);

            return redirect()->back()->with('success','Workout Plan added to your Library');
        }
        else
        {
            return redirect()->back()->with('error','Workout Plan is already on your Library');
        }

    }

    public function delete_library(Request $request)
    {
        $id = $request->segment(3);

        $check = DB::table('trainer_workout_plans')->where(['trainer_workout_plan'=>$id,'trainer_workout_trainer'=>Auth::guard('trainer')->user()->trainer_id])->count();

        if($check > 0)
        {
            DB::table('trainer_workout_plans')->where(['trainer_workout_plan'=>$id,'trainer_workout_trainer'=>Auth::guard('trainer')->user()->trainer_id])->delete();

            return redirect()->back()->with('success','Workout Plan deleted from Library');
        }
        else
        {
            return redirect()->back()->with('error','Workout Plan is not in your Library');
        }

    }

}
