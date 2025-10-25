<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Workout;
use App\Models\ExerciseType;
use App\Models\WorkoutPlan;

class UserWorkoutController extends BaseController
{
    public function index(Request $request)
    {
        $workout_plans = WorkoutPlan::where(['workout_plan_status'=>1,'workout_plan_trash'=>0])->get();
        if($workout_plans->count() > 0)
        {
            foreach($workout_plans as $key=> $workout_plan)
            {
                $plan[$key]['workout_plan_id'] = $workout_plan->workout_plan_id;
                $plan[$key]['workout_plan_name '] = $workout_plan->workout_plan_name;
                $plan[$key]['workout_plan_category '] = $workout_plan->workout_category_name;
                $plan[$key]['workout_plan_duration '] = $workout_plan->workout_plan_duration;
                $plan[$key]['workout_plan_goal '] = $workout_plan->workout_plan_goal;
                $plan[$key]['workout_plan_days '] = $workout_plan->workout_plan_days;
            }
            $result['workout_plans'] = $plan;
            return $this->sendResponse($result,'Workout Plan List.');
        }
        else
        {
            return $this->sendResponse([],'No Workout Plan found');
        }

    }

    public function search_workout(Request $request)
    {
        $where['workout_plan_status'] = 1;
        $where['workout_plan_trash'] = 0;
        if($request->search != NULL)
        {
            $workout_plans = WorkoutPlan::where($where)
                    ->where('workout_plan_name', 'like', '%' . $request->search . '%')
                    ->get();
        }
        else
        {
            $workout_plans = WorkoutPlan::where(['workout_plan_status'=>1,'workout_plan_trash'=>0])->get();
        }

        if($workout_plans->count() > 0)
        {
            foreach($workout_plans as $key=> $workout_plan)
            {
                $plan[$key]['workout_plan_id'] = $workout_plan->workout_plan_id;
                $plan[$key]['workout_plan_name '] = $workout_plan->workout_plan_name;
                $plan[$key]['workout_plan_category '] = $workout_plan->workout_category_name;
                $plan[$key]['workout_plan_duration '] = $workout_plan->workout_plan_duration;
                $plan[$key]['workout_plan_goal '] = $workout_plan->workout_plan_goal;
                $plan[$key]['workout_plan_days '] = $workout_plan->workout_plan_days;
            }
            $result['workout_plans'] = $plan;
            return $this->sendResponse($result,'Workout Plan List.');
        }
        else
        {
            return $this->sendResponse([],'No Workout Plan found');
        }

    }

    public function workout_plan_detail(Request $request)
    {
        $rules = ['workout_plan_id' => 'required',];

        $messages = ['workout_plan_id.required'=>'Please provide workout plan id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $workout_plan = WorkoutPlan::where('workout_plan_id',$request->workout_plan_id)->first();

        if(isset($workout_plan))
        {
            $result['workout_plan_id'] = $workout_plan->workout_plan_id;
            $result['workout_plan_name '] = $workout_plan->workout_plan_name;
            $result['workout_plan_category '] = $workout_plan->workout_category_name;
            $result['workout_plan_duration '] = $workout_plan->workout_plan_duration;
            $result['workout_plan_goal '] = $workout_plan->workout_plan_goal;
            $result['workout_plan_days '] = $workout_plan->workout_plan_days;

            return $this->sendResponse($result,'Workout Plan Detail.');
        }
        else
        {
            return $this->sendResponse([],'No Workout Plan found');
        }

    }

}
