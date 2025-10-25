<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Blocked;

class UserBlockedController extends BaseController
{
    public function index(Request $request)
    {
         $rules = ['user_id' => 'required',];

        $messages = ['user_id.required'=>'Please provide user id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $block = Blocked::where(['blocked_user'=>$request->user_id,'blocked_added_by'=>Auth::user()->id]);
        if($request->user_id == Auth::user()->id)
        {
            return $this->sendError("Action cannot be Done", []);
        }
        $user = User::find($request->user_id);
        if(isset($user))
        {
            $user_name = ($user->lname != NULL) ? $user->fname.' '.$user->lname : $user->fname;
            if(isset($user) && $block->count() == 0)
            {
                $ins['blocked_user'] = $request->user_id;
                $ins['blocked_added_on']   = date('Y-m-d H:i:s');
                $ins['blocked_added_by']   = Auth::user()->id;
                $ins['blocked_updated_on'] = date('Y-m-d H:i:s');
                $ins['blocked_updated_by'] = Auth::user()->id;

                $insert = Blocked::create($ins);

                return $this->sendResponse([],'You are now blocked '.$user_name);
            }
            else
            {
                $blocked = $block->first();

                if($blocked->blocked_trash == 1)
                {
                    $update = Blocked::where('blocked_id',$blocked->blocked_id)->update(['blocked_trash'=>0,'blocked_updated_on'=>date('Y-m-d H:i:s')]);
                    return $this->sendResponse([],'You have blocked '.$user_name);
                }
            }
        }
        else
        {
            return $this->sendError("User not Found", []);
        }

    }

    public function unblock(Request $request)
    {
         $rules = ['user_id' => 'required',];

        $messages = ['user_id.required'=>'Please provide user id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $block = Blocked::where(['blocked_user'=>$request->user_id,'blocked_added_by'=>Auth::user()->id]);
        if($request->user_id == Auth::user()->id)
        {
            return $this->sendError("Action cannot be Done", []);
        }
        $user = User::find($request->user_id);
        if(isset($user))
        {
            $user_name = ($user->lname != NULL) ? $user->fname.' '.$user->lname : $user->fname;
            if(isset($user) && $block->count() > 0)
            {
                $blocked = $block->first();
                $update = Blocked::where('blocked_id',$blocked->blocked_id)->update(['blocked_trash'=>1]);

                return $this->sendResponse([],'You have unblocked '.$user_name);
            }
            else
            {
                return $this->sendResponse([],'You have not blocked '.$user_name);
            }
        }
        else
        {
            return $this->sendError("User not Found", []);
        }
    }

    public function blocked_list(Request $request)
    {
        $blocked = Blocked::getDetails(['blocked_added_by'=>Auth::user()->id,'blocked_trash'=>0]);
        if($blocked->count() > 0)
        {
            foreach($blocked as $key=> $block)
            {
                $user_name = ($block->lname != NULL) ? $block->fname.' '.$block->lname : $block->fname;
                $blo[$key]['user_id'] = $block->id;
                $blo[$key]['user_image'] = asset(config('constants.user_path').'uploads/profile/'.$block->image);
                $blo[$key]['user_name'] =  $user_name;
            }
            $result['blocked'] = $blo;
            return $this->sendResponse($result,'Blocked List.');
        }
        else
        {
            return $this->sendError("No Blocked users found", []);
        }
    }

}
