<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use DataTables;
use DB;
use App\Models\VideoSection;
use App\Models\Video;
class TrainerVideoController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'videos';
        $data['video_sections'] = VideoSection::getDetails(['video_section_added_by'=>Auth::guard('trainer')->user()->trainer_id]);
        $videos = Video::getDetails(['video_added_by'=>Auth::guard('trainer')->user()->trainer_id]);

        if($videos->count() > 0)
        {
            foreach($videos as $video)
            {
                $data['videos'][$video->video_section][] = $video;
            }
        }
        else
        {
            $data['videos'] = array();
        }

        return view('trainer.videos.videos',$data);
    }

    public function create_section(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'video_section_title' => 'required',];

            $messages = ['video_section_title.required'=>'Please enter title'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['video_section_title'] = $request->video_section_title;

            $check = VideoSection::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Title already in use')->withInput();
            }

            $ins['video_section_title']        = $request->video_section_title;
            $ins['video_section_status']       = ($request->video_section_status) ? $request->video_section_status : 2;
            $ins['video_section_role']         = 3;
            $ins['video_section_added_by']     = Auth::guard('trainer')->user()->trainer_id;
            $ins['video_section_added_on']     = date('Y-m-d H:i:s');
            $ins['video_section_updated_by']   = Auth::guard('trainer')->user()->trainer_id;
            $ins['video_section_updated_on']   = date('Y-m-d H:i:s');

            if($request->hasFile('video_section_image'))
            {
                $video_section_image = $request->video_section_image->store('assets/trainer/uploads/video');

                $video_section_image = explode('/',$video_section_image);
                $video_section_image = end($video_section_image);
                $ins['video_section_image'] = $video_section_image;
            }

            $section_id = VideoSection::insertGetId($ins);

            if($section_id)
            {
                return redirect()->back()->with('success','Video Section Added Successfully');
            }
        }
    }

    public function section_detail(Request $request)
    {
        if($request->ajax())
        {
            $section_id = $request->section_id;

            $section = VideoSection::where('video_section_id',$section_id)->first()->toArray();
            if(isset($section))
            {
                $data['error'] = 0;
                $data['name'] = $section['video_section_title'];
                $data['status'] = $section['video_section_status'];
                $data['image'] = $section['video_section_image'];
            }
            else
            {
                $data['error'] = 0;
            }

            echo json_encode($data);

        }
    }

    public function edit_section(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'video_section_title' => 'required',];

            $messages = ['video_section_title.required'=>'Please enter title'];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            else
            {
                $where['video_section_title'] = $request->video_section_title;
                $check_name = VideoSection::where($where)->where('video_section_id','!=',$request->video_section_id)->count();

                if($check_name > 0)
                {
                    return redirect()->back()->with('error','Title already in use')->withInput();
                }

                $upd['video_section_title']        = $request->video_section_title;
                $upd['video_section_status']       = ($request->video_section_status) ? $request->video_section_status : 2;
                $upd['video_section_updated_by']   = Auth::guard('trainer')->user()->trainer_id;
                $upd['video_section_updated_on']   = date('Y-m-d H:i:s');

                if($request->hasFile('video_section_image'))
                {
                    $video_section_image = $request->video_section_image->store('assets/trainer/uploads/video');

                    $video_section_image = explode('/',$video_section_image);
                    $video_section_image = end($video_section_image);
                    $upd['video_section_image'] = $video_section_image;
                }

                $update = VideoSection::where('video_section_id',$request->video_section_id)->update($upd);

                if($update)
                {
                    return redirect()->back()->with('success','Video Section Updated Successfully');
                }
            }
        }
    }

    public function add_video(Request $request)
    {
        $data['set'] = 'videos';
        $data['video_sections'] = VideoSection::getDetails(['video_section_added_by'=>Auth::guard('trainer')->user()->trainer_id]);
        return view('trainer.videos.add_video',$data);
    }

    public function create_video(Request $request)
    {
        if($request->has('submit'))
        {
            $rules = [ 'video_title' => 'required',
                       'video_section' => 'required',
                       'video_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                       'video_date' => 'required',
                       'video_time' => 'required',];

            $messages = ['video_title.required'=>'Please enter title',
                        'video_section.required'=>'Please choose Section',
                        'video_image.required'=>'Please choose image',
                        'video_date.required'=>'Please choose date',
                        'video_time.required'=>'Please choose time',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['video_title'] = $request->video_title;
            $where['video_section'] = $request->video_section;
            $check = Video::where($where)->count();

            if($check > 0)
            {
                return redirect()->back()->with('error','Title already in use')->withInput();
            }

            $ins['video_title']                = $request->video_title;
            $ins['video_section']              = $request->video_section;
            $ins['video_date']                 = $request->video_date;
            $ins['video_time']                 = $request->video_time;
            $ins['video_description']          = $request->video_description;
            $ins['video_vimeo']                = $request->video_vimeo;
            $ins['video_youtube']              = $request->video_youtube;
            $ins['video_status']               = ($request->video_status) ? $request->video_status : 2;
            $ins['video_featured']             = ($request->video_featured) ? $request->video_featured : 2;
            $ins['video_role']                 = 3;
            $ins['video_added_by']             = Auth::guard('trainer')->user()->trainer_id;
            $ins['video_added_on']             = date('Y-m-d H:i:s');
            $ins['video_updated_by']           = Auth::guard('trainer')->user()->trainer_id;
            $ins['video_updated_on']           = date('Y-m-d H:i:s');

            if($request->hasFile('video_image'))
            {
                $video_image = $request->video_image->store('assets/trainer/uploads/video');

                $video_image = explode('/',$video_image);
                $video_image = end($video_image);
                $ins['video_image'] = $video_image;
            }

            if($request->hasFile('video_file'))
            {
                $video_file = $request->video_file->store('assets/trainer/uploads/video');

                $video_file = explode('/',$video_file);
                $video_file = end($video_file);
                $ins['video_file'] = $video_file;
            }

            $video_id = Video::insertGetId($ins);

            if($video_id)
            {
                return redirect()->back()->with('success','Video Added Successfully');
            }
        }
    }

    public function edit_video(Request $request)
    {
        $data['video'] = $video = Video::where('video_id',$request->segment(3))->first();
        $data['video_sections'] = VideoSection::getDetails(['video_section_added_by'=>Auth::guard('trainer')->user()->trainer_id]);

        if(!isset($data['video']))
        {
            return redirect('trainer/video');
        }

        $data['set'] = 'videos';
        return view('trainer.videos.edit_video',$data);
    }

    public function update_video(Request $request)
    {
        $video = Video::where('video_id',$request->segment(3))->first();

        if($request->has('submit'))
        {
            $rules = [ 'video_title' => 'required',
                       'video_section' => 'required',
                       'video_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                       'video_date' => 'required',
                       'video_time' => 'required',];

            $messages = ['video_title.required'=>'Please enter title',
                        'video_section.required'=>'Please choose Section',
                        'video_date.required'=>'Please choose date',
                        'video_time.required'=>'Please choose time',];

            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $where['video_title'] = $request->video_title;
            $where['video_section'] = $request->video_section;
            $check_name = Video::where($where)->where('video_id','!=',$request->segment(3))->count();

            if($check_name > 0)
            {
                return redirect()->back()->with('error','Title already in use')->withInput();
            }

            $upd['video_title']              = $request->video_title;
            $upd['video_section']            = $request->video_section;
            $upd['video_date']               = $request->video_date;
            $upd['video_time']               = $request->video_time;
            $upd['video_description']        = $request->video_description;
            $upd['video_vimeo']              = $request->video_vimeo;
            $upd['video_youtube']            = $request->video_youtube;
            $upd['video_status']             = ($request->video_status) ? $request->video_status : 2;
            $upd['video_featured']           = ($request->video_featured) ? $request->video_featured : 2;
            $upd['video_updated_by']         = Auth::guard('trainer')->user()->trainer_id;
            $upd['video_updated_on']         = date('Y-m-d H:i:s');

            if($request->hasFile('video_image'))
            {
                $video_image = $request->video_image->store('assets/trainer/uploads/video');

                $video_image = explode('/',$video_image);
                $video_image = end($video_image);
                $upd['video_image'] = $video_image;
            }

            if($request->hasFile('video_file'))
            {
                $video_file = $request->video_file->store('assets/trainer/uploads/video');

                $video_file = explode('/',$video_file);
                $video_file = end($video_file);
                $upd['video_file'] = $video_file;
            }

            $update = Video::where('video_id',$request->segment(3))->update($upd);

            if($update)
            {
                return redirect()->back()->with('success','Video Updated Successfully');
            }
        }
    }

}
