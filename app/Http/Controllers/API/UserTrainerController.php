<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\TrainerReview;
use App\Models\Video;
use App\Models\Following;
use App\Models\TrainerCertificate;
use DB;

class UserTrainerController extends BaseController
{
    public function index(Request $request)
    {
        $trainers = User::where(['status'=>1,'role'=>2])->get();
        if($trainers->count() > 0)
        {
            foreach($trainers as $key=> $user)
            {
                $train[$key]['id'] = $user->id;
                $train[$key]['image'] = asset(config('constants.user_path').'uploads/profile/'.$user->image);
                $train[$key]['name'] = ($user->lname != NULL) ? $user->fname.' '.$user->lname : $user->fname;
                $train[$key]['title'] = $user->title;
                $train[$key]['bio'] = $user->bio;
            }
            $result['trainers'] = $train;
            return $this->sendResponse($result,'Trainers List.');
        }
        else
        {
            return $this->sendError("No Trainers found", []);
        }

    }

    public function search_trainer(Request $request)
    {
        $where['status'] = 1;
        $where['role'] = 2;
        if($request->search)
        {
            $trainers = User::where($where)
                    ->where('fname', 'like', '%' . $request->search . '%')
                    ->orWhere('lname', 'like', '%' . $request->search . '%')
                    ->get();
        }
        else
        {
            $trainers = User::where($where)->get();
        }

        if($trainers->count() > 0)
        {
            foreach($trainers as $key=> $user)
            {
                $train[$key]['id'] = $user->id;
                $train[$key]['image'] = asset(config('constants.user_path').'uploads/profile/'.$user->image);
                $train[$key]['name'] = ($user->lname != NULL) ? $user->fname.' '.$user->lname : $user->fname;
                $train[$key]['title'] = $user->title;
                $train[$key]['bio'] = $user->bio;
            }
            $result['trainers'] = $train;
            return $this->sendResponse($result,'Trainers List.');
        }
        else
        {
            return $this->sendError("No Trainers found", []);
        }

    }

    public function about_trainer(Request $request)
    {
        $rules = ['trainer_id' => 'required',];

        $messages = ['trainer_id.required'=>'Please provide trainer id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $trainer = User::where(['id'=>$request->trainer_id,'role'=>2])->first();
        $videos = Video::where(['video_added_by'=>$request->trainer_id,'video_status'=>1,'video_trash'=>0])->get();
        $reviews = TrainerReview::getDetails(['review_user'=>$request->trainer_id]);
        $certificates = TrainerCertificate::where(['certificate_added_by'=>$request->trainer_id,'certificate_status'=>1,'certificate_trash'=>0])->get();

        if($videos->count() > 0)
        {
            foreach($videos as $key=> $video)
            {
                $vid[$key]['video_id'] = $video->video_id;
                $vid[$key]['video_title'] = $video->video_title;
                $vid[$key]['video_image'] = asset(config('constants.trainer_path').'uploads/video/'.$video->video_image);
                $vid[$key]['video_description'] = $video->video_description;
                $vid[$key]['video_date'] = $video->video_date;
                $vid[$key]['video_time'] = $video->video_time;
                $vid[$key]['video_link'] = ($video->video_vimeo != NULL) ? $video->video_vimeo : $video->video_youtube;
                $vid[$key]['video_featured'] = $video->video_featured;
            }

        }
        else
        {
            $vid = array();
        }

        if($reviews->count() > 0)
        {
            $one = array();
            $two = array();
            $three = array();
            $four = array();
            $five = array();
            foreach($reviews as $rkey => $review)
            {
                if($review->review_rating == 1)
                {
                    $one[] = $review->review_id;
                }
                if($review->review_rating == 2)
                {
                    $two[] = $review->review_id;
                }
                if($review->review_rating == 3)
                {
                    $three[] = $review->review_id;
                }
                if($review->review_rating == 4)
                {
                    $four[] = $review->review_id;
                }
                if($review->review_rating == 5)
                {
                    $five[] = $review->review_id;
                }

                $rev[$rkey]['review_id'] = $review->review_id;
                $rev[$rkey]['review_rating'] = $review->review_rating;
                $rev[$rkey]['review_comment'] = $review->review_comment;
                $rev[$rkey]['review_date'] = date('M d,Y h:i A',strtotime($review->review_added_on));
                $rev[$rkey]['user'] = ($review->lname != NULL) ? $review->fname.' '.$review->lname : $review->fname;
                $rev[$rkey]['user_image'] = asset(config('constants.user_path').'uploads/profile/'.$review->image);
                $rev[$rkey]['likes'] = 0;
                $rev[$rkey]['dislikes'] = 0;
            }
        }
        else
        {
            $rev = array();
        }
        if($certificates->count() > 0)
        {
            foreach($certificates as $key=> $certificate)
            {
                $cert[$key]['certificate_id'] = $certificate->certificate_id;
                $cert[$key]['certificate_title'] = $certificate->certificate_title;
                $cert[$key]['certificate_image'] = asset(config('constants.trainer_path').'uploads/certificate/'.$certificate->certificate_image);
            }
        }

        if(isset($trainer))
        {
            $result['name']   = ($trainer->lname != NULL) ? $trainer->fname.' '.$trainer->lname : $trainer->fname;
            $result['title']  = $trainer->title;
            $result['email '] = $trainer->email;
            $result['uname']  = $trainer->uname;
            $result['gender'] = $trainer->gender;
            $result['image']  = ($trainer->image != NULL) ? url(asset(config('constants.user_path').'uploads/profile/'.$trainer->image)) : url(asset(config('constants.user_path').'uploads/no-image.png'));
            $result['role']   = ($trainer->role == 1) ? 'Client' : 'Trainer';
            $result['banner'] = ($trainer->cover_image != NULL) ? url(asset(config('constants.user_path').'uploads/profile/'.$trainer->cover_image)) : url(asset(config('constants.user_path').'uploads/no-image.png'));
            $result['bio']    = $trainer->bio;
            $result['following'] = Following::getDetails(['following_added_by'=>$trainer->id,'following_trash'=>0])->count();
            $result['followers'] = Following::getDetails(['following_follower'=>$trainer->id,'following_trash'=>0])->count();
            $result['certificates'] = $cert;
            $result['videos'] = $vid;
            $result['rating']['avg_rating'] = (1 * array_sum($one)) + (2 * array_sum($two)) + (3 * array_sum($three)) + (4 *array_sum($four)) + (5 * array_sum($five)) / $reviews->count();
            $result['rating']['total_rating'] = $reviews->count();
            $result['rating']['five_star'] = array_sum($five);
            $result['rating']['four_star'] = array_sum($four);
            $result['rating']['three_star'] = array_sum($three);
            $result['rating']['two_star'] = array_sum($two);
            $result['rating']['one_star'] = array_sum($one);
            $result['reviews'] = $rev;


            return $this->sendResponse($result,'About Trainer.');
        }
        else
        {
            return $this->sendError("No Trainer found", []);
        }

    }

    public function add_review(Request $request)
    {
        $rules = ['trainer_id' => 'required',
                  'rating' => 'required|numeric|min:1|max:5',
                  'review' => 'required|string|min:10|max:1000'];

        $messages = ['trainer_id.required'=>'Please provide trainer id',
                    'rating.required'=>'Please provide rating',
                    'review.required'=>'Please provide review'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $trainer = User::where(['id'=>$request->trainer_id,'role'=>2])->first();
        if(!isset($trainer))
        {
            return $this->sendError([], ['error'=>'Trainer not found']);
        }

        $ins['review_user']        = $request->trainer_id;
        $ins['review_rating']      = $request->rating;
        $ins['review_added_by']    = Auth::user()->id;
        $ins['review_added_on']    = date('Y-m-d H:i:s');
        $ins['review_updated_by']  = Auth::user()->id;
        $ins['review_updated_on']  = date('Y-m-d H:i:s');

        $review_id = TrainerReview::insertGetId($ins);

        if($review_id)
        {
            return $this->sendResponse([],'Review Added.');
        }

    }

    public function review_like(Request $request)
    {
        $rules = ['review_id' => 'required|numeric',
                  'like' => 'required|numeric|min:1|max:2'];

        $messages = ['review_id.required'=>'Please provide review id',
                    'like.required'=>'Please provide like',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $review = TrainerReview::where(['review_id'=>$request->review_id])->first();

        if(!isset($review))
        {
            return $this->sendError([], ['error'=>'Review not found']);
        }

        $like = DB::table('trainer_review_likes')->where(['review_like_review'=>$request->review_id,'review_like_added_by'=>Auth::user()->id])->count();

        if($like > 0)
        {
           return $this->sendError([], ['error'=>'You have already liked this review']);
        }

        $ins['review_like_review'] = $request->review_id;
        $ins['review_like_type']    = $request->like;
        $ins['review_like_added_by']    = Auth::user()->id;
        $ins['review_like_added_on']    = date('Y-m-d H:i:s');
        $ins['review_like_updated_by']  = Auth::user()->id;
        $ins['review_like_updated_on']  = date('Y-m-d H:i:s');

        $like = DB::table('trainer_review_likes')->insert($ins);

        if($like)
        {
            if($request->like == 1)
            {
                return $this->sendResponse([],'Liked Review.');
            }
            else
            {
                return $this->sendResponse([],'Disliked Review.');
            }

        }

    }

    public function remove_review_like(Request $request)
    {
        $rules = ['review_id' => 'required|numeric'];

        $messages = ['review_id.required'=>'Please provide review id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $review = DB::table('trainer_review_likes')->where(['review_like_review'=>$request->review_id,'review_like_added_by'=>Auth::user()->id])->first();

        if(isset($review))
        {
            $delete = DB::table('trainer_review_likes')->where(['review_like_review'=>$request->review_id,'review_like_added_by'=>Auth::user()->id])->delete();

            return $this->sendResponse([],'Like Removed.');
        }
        else
        {
            return $this->sendError([], ['error'=>'No like found']);
        }



    }

}
