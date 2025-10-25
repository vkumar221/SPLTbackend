<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Following;

class UserFollowController extends BaseController
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

        $follow = Following::where(['following_follower'=>$request->user_id,'following_added_by'=>Auth::user()->id]);
        if($request->user_id == Auth::user()->id)
        {
            return $this->sendError("Action cannot be Done", []);
        }
        $user = User::find($request->user_id);
        if(isset($user))
        {
            $user_name = ($user->lname != NULL) ? $user->fname.' '.$user->lname : $user->fname;
            if(isset($user) && $follow->count() == 0)
            {
                $ins['following_follower'] = $request->user_id;
                $ins['following_added_on']   = date('Y-m-d H:i:s');
                $ins['following_added_by']   = Auth::user()->id;
                $ins['following_updated_on'] = date('Y-m-d H:i:s');
                $ins['following_updated_by'] = Auth::user()->id;

                $insert = Following::create($ins);

                return $this->sendResponse([],'You are now following '.$user_name);
            }
            else
            {
                $following = $follow->first();

                if($following->following_trash == 1)
                {
                    $update = Following::where('following_id',$following->following_id)->update(['following_trash'=>0,'following_updated_on'=>date('Y-m-d H:i:s')]);
                    return $this->sendResponse([],'You are now following '.$user_name);
                }
                else
                {
                     return $this->sendResponse([],'You are already following '.$user_name);
                }
            }
        }
        else
        {
            return $this->sendError("User not Found", []);
        }

    }

    public function unfollow(Request $request)
    {
         $rules = ['user_id' => 'required',];

        $messages = ['user_id.required'=>'Please provide user id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $follow = Following::where(['following_follower'=>$request->user_id,'following_added_by'=>Auth::user()->id]);
        if($request->user_id == Auth::user()->id)
        {
            return $this->sendError("Action cannot be Done", []);
        }
        $user = User::find($request->user_id);
        if(isset($user))
        {
            $user_name = ($user->lname != NULL) ? $user->fname.' '.$user->lname : $user->fname;
            if(isset($user) && $follow->count() > 0)
            {
                $following = $follow->first();
                $update = Following::where('following_id',$following->following_id)->update(['following_trash'=>1]);

                return $this->sendResponse([],'You have unfollowed '.$user_name);
            }
            else
            {
                return $this->sendResponse([],'You are not following '.$user_name);
            }
        }
        else
        {
            return $this->sendError("User not Found", []);
        }
    }

    public function follwing_list(Request $request)
    {
        $followings = Following::getDetails(['following_added_by'=>Auth::user()->id,'following_trash'=>0]);
        if($followings->count() > 0)
        {
            foreach($followings as $key=> $follow)
            {
                $user_name = ($follow->lname != NULL) ? $follow->fname.' '.$follow->lname : $follow->fname;
                $follo[$key]['user_id'] = $follow->id;
                $follo[$key]['user_image'] = asset(config('constants.user_path').'uploads/profile/'.$follow->image);
                $follo[$key]['user_name'] =  $user_name;
            }
            $result['follwing'] = $follo;
            return $this->sendResponse($result,'Following List.');
        }
        else
        {
            return $this->sendError("No Following users found", []);
        }
    }

    public function follwer_list(Request $request)
    {
        $followings = Following::getDetails(['following_follower'=>Auth::user()->id,'following_trash'=>0]);
        if($followings->count() > 0)
        {
            foreach($followings as $key=> $follow)
            {
                $user_name = ($follow->lname != NULL) ? $follow->fname.' '.$follow->lname : $follow->fname;
                $follo[$key]['user_id'] = $follow->id;
                $follo[$key]['user_image'] = asset(config('constants.user_path').'uploads/profile/'.$follow->image);
                $follo[$key]['user_name'] =  $user_name;
            }
            $result['follwers'] = $follo;
            return $this->sendResponse($result,'Follwers List.');
        }
        else
        {
            return $this->sendError("No Follwers found", []);
        }
    }

}
