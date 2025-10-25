<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Faq;
use App\Models\UserQuestion;
use App\Models\ClientMeasurement;
use DB;

class UserSettingController extends BaseController
{
    public function faq(Request $request)
    {
        $faqs = Faq::where('faq_status',1)->get();
        if($faqs->count() > 0)
        {
            foreach($faqs as $key=> $faq)
            {
                $fa[$key]['faq_question'] = $faq->faq_question;
                $fa[$key]['faq_answer'] = $faq->faq_answer;
            }
            $result['faqs'] = $fa;
            return $this->sendResponse($result,'FAQ.');
        }
        else
        {
            return $this->sendResponse([],'No FAQ found');
        }

    }

    public function search_faq(Request $request)
    {
        $where['faq_status'] = 1;
        if($request->search != NULL)
        {
            $faqs = Faq::where($where)
                    ->where('faq_question', 'like', '%' . $request->search . '%')
                    ->get();
        }
        else
        {
            $faqs = Faq::where($where)->get();
        }

        if($faqs->count() > 0)
        {
            foreach($faqs as $key=> $faq)
            {
                $fa[$key]['faq_question'] = $faq->faq_question;
                $fa[$key]['faq_answer'] = $faq->faq_answer;
            }
            $result['faqs'] = $fa;
            return $this->sendResponse($result,'FAQ.');
        }
        else
        {
            return $this->sendResponse([],'No FAQ found');
        }

    }

    public function submit_question(Request $request)
    {
        $rules = ['question' => 'required',];

        $messages = ['question.required'=>'Please provide Question',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $ins['user_question']            = $request->question;
        $ins['user_question_status']     = 1;
        $ins['user_question_added_by']   = Auth::user()->id;
        $ins['user_question_added_on']   = date('Y-m-d H:i:s');
        $ins['user_question_updated_by'] = Auth::user()->id;
        $ins['user_question_updated_on'] = date('Y-m-d H:i:s');

        $insert = UserQuestion::insertGetId($ins);

        if($insert)
        {
            return $this->sendResponse([],'Question Submitted.');
        }

    }

    public function measurement_parts(Request $request)
    {
        $body_parts = DB::table('body_parts')->where('body_part_status',1)->get();

        if($body_parts->count() > 0)
        {
            foreach($body_parts as $key=> $body_part)
            {
                $body[$key]['measurement_part_id'] = $body_part->body_part_id;
                $body[$key]['measurement_part_name'] = $body_part->body_part_name;
            }
            $result['body_parts'] = $body;
            return $this->sendResponse($result,'Body Part List.');
        }
        else
        {
            return $this->sendResponse([],'No Body Part found');
        }

    }

    public function add_measurement(Request $request)
    {
        $rules = ['measurement_part_id' => 'required',
                 'measurement_date' => 'required|date_format:d-m-Y',
                 'measurement' => 'required',
            ];

        $messages = ['measurement_part_id.required'=>'Please provide Part ID',
                     'measurement_date.required'=>'Please provide Date',
                      'measurement.required'=>'Please provide Measurement',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $check = ClientMeasurement::where(['client_measurement_part'=>$request->measurement_part_id,'client_measurement_client'=>Auth::user()->id,'client_measurement_date'=>$request->measurement_date])->count();

        if($check == 0)
        {
            $ins['client_measurement_part']       = $request->measurement_part_id;
            $ins['client_measurement']            = $request->measurement;
            $ins['client_measurement_date']       = $request->measurement_date;
            $ins['client_measurement_client']     = Auth::user()->id;
            $ins['client_measurement_status']     = 1;
            $ins['client_measurement_added_by']   = Auth::user()->id;
            $ins['client_measurement_added_on']   = date('Y-m-d H:i:s');
            $ins['client_measurement_updated_by'] = Auth::user()->id;
            $ins['client_measurement_updated_on'] = date('Y-m-d H:i:s');

            $insert = ClientMeasurement::insertGetId($ins);

            if($insert)
            {
                return $this->sendResponse([],'Measurement Added.');
            }
        }
        else
        {
            return $this->sendError([], ['error'=>'Measurement for this part is Already added on this date']);
        }

    }

}
