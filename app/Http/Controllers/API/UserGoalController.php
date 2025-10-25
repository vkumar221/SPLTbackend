<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\UserGoal;
use DB;

class UserGoalController extends BaseController
{
    public function index(Request $request)
    {
        $goals = UserGoal::getDetails(['user_goal_user'=>Auth::user()->id,'user_goal_trash'=>0]);
        $levels = DB::table('levels')->where(['level_status'=>1])->get();
        $gol = array();
        $achv = array();
        if($goals->count() > 0)
        {
            foreach($goals as $key=> $goal)
            {
                $gol[$key]['goal_id'] = $goal->user_goal_id;
                $gol[$key]['goal_title'] = $goal->user_goal_name;
                $gol[$key]['goal_type'] = $goal->goal_type_name;
                $gol[$key]['steps'] = $goal->user_goal_steps;
                $gol[$key]['steps_target'] = $goal->user_goal_steps_target;
                $gol[$key]['duration'] = $goal->user_goal_duration;
            }
        }
        if($levels->count() > 0)
        {
            foreach($levels as $lkey=> $level)
            {
                $lvl[$lkey]['level_id'] = $level->level_id;
                $lvl[$lkey]['level_title'] = $level->level_name;
                $lvl[$lkey]['level_check'] = (Auth::user()->level >= $level->level_id) ? 1 : 0;
            }
        }
        $result['total_goals'] = $goals->count();
        $result['total_acheivements'] = 0;
        $result['goals'] = $gol;
        $result['levels'] = $lvl;
        $result['acheivements'] = $achv;

        return $this->sendResponse($result,'Goals.');

    }

    public function goal_types(Request $request)
    {
        $goal_types = DB::table('goal_types')->where('goal_type_status',1)->get();
        if($goal_types->count() > 0)
        {
            foreach($goal_types as $key=> $goal_type)
            {
                $gol[$key]['goal_type_id'] = $goal_type->goal_type_id;
                $gol[$key]['goal_type_name'] = $goal_type->goal_type_name;
            }
            $result['goal_types'] = $gol;
            return $this->sendResponse($result,'Goal Types List.');
        }
        else
        {
            return $this->sendResponse([],'No Goal Types found');
        }

    }

    public function add_goal(Request $request)
    {
        $rules = ['goal_title' => 'required',
                  'goal_type_id' => 'required',
                   'goal_duration' => 'required',
                   'goal_steps' => 'required',
                   'goal_steps_target' => 'required'];

        $messages = ['goal_title.required'=>'Please provide Title',
                    'goal_type_id.required'=>'Please provide Type ID',
                    'goal_duration.required'=>'Please provide Duration',
                    'goal_steps.required'=>'Please provide Steps',
                    'goal_steps_target.required'=>'Please Steps Target',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $ins['user_goal_user']               = Auth::user()->id;
        $ins['user_goal_name']               = $request->goal_title;
        $ins['user_goal_type']               = $request->goal_type_id;
        $ins['user_goal_steps']              = $request->goal_steps;
        $ins['user_goal_steps_target']       = $request->goal_steps_target;
        $ins['user_goal_status']             = 1;
        $ins['user_goal_role']               = Auth::user()->role;
        $ins['user_goal_added_by']           = Auth::user()->id;
        $ins['user_goal_added_on']           = date('Y-m-d H:i:s');
        $ins['user_goal_updated_by']         = Auth::user()->id;
        $ins['user_goal_updated_on']         = date('Y-m-d H:i:s');

        $goal_id = UserGoal::insertGetId($ins);

        if($goal_id)
        {
            return $this->sendResponse([],'Goal Added.');
        }
    }


}
