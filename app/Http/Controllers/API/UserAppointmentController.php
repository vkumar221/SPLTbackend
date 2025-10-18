<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Appointment;

class UserAppointmentController extends BaseController
{
    public function index(Request $request)
    {
        $rules = ['user_id' => 'required',
                    'date' => 'required',
                    'time' => 'required'];

        $messages = ['user_id.required'=>'Please provide user id',
                     'date.required'=>'Please enter date',
                     'time.required'=>'Please enter time'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $user = User::find($request->user_id);

        if(isset($user))
        {
            $user_name = ($user->lname != NULL) ? $user->fname.' '.$user->lname : $user->fname;

            $ins['appointment_user']       = $request->user_id;
            $ins['appointment_date']       = $request->date;
            $ins['appointment_time']       = $request->time;
            $ins['appointment_added_on']   = date('Y-m-d H:i:s');
            $ins['appointment_added_by']   = Auth::user()->id;
            $ins['appointment_updated_on'] = date('Y-m-d H:i:s');
            $ins['appointment_updated_by'] = Auth::user()->id;

            $insert = Appointment::create($ins);

            return $this->sendResponse([],'You booked an appointment with '.$user_name);
        }
        else
        {
            return $this->sendError("User not Found", []);
        }

    }

    public function appointment_list(Request $request)
    {
        $appointments = Appointment::getDetails(['appointment_added_by'=>Auth::user()->id,'appointment_trash'=>0]);
        if($appointments->count() > 0)
        {
            foreach($appointments as $key=> $appointment)
            {
                if($appointment->appointment_status == 1)
                {
                    $status = 'Pending';
                }
                elseif($appointment->appointment_status == 2)
                {
                    $status = 'Confirmed';
                }
                elseif($appointment->appointment_status == 3)
                {
                    $status = 'Completed';
                }
                else
                {
                    $status = 'Cancelled';
                }
                $user_name = ($appointment->lname != NULL) ? $appointment->fname.' '.$appointment->lname : $appointment->fname;
                $appoint[$key]['appointment_id']    = $appointment->appointment_id;
                $appoint[$key]['user_image']        = asset(config('constants.user_path').'uploads/profile/'.$appointment->image);
                $appoint[$key]['user_name']         =  $user_name;
                $appoint[$key]['appointment_date']  =  $appointment->appointment_date;
                $appoint[$key]['appointment_time']  =  $appointment->appointment_time;
                $appoint[$key]['status']            = $status;
            }
            $result['appointments'] = $appoint;
            return $this->sendResponse($result,'Appointment List.');
        }
        else
        {
            return $this->sendError("No Appointments found", []);
        }
    }

    public function appointment_cancel(Request $request)
    {
        $rules = ['appointment_id' => 'required'];

        $messages = ['appointment_id.required'=>'Please provide apointment Id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $appointment = Appointment::getDetails(['appointment_added_by'=>Auth::user()->id,'appointment_id'=>$request->appointment_id])->first();

        if(isset($appointment))
        {
            $user_name = ($appointment->lname != NULL) ? $appointment->fname.' '.$appointment->lname : $appointment->fname;

            $update = Appointment::where('appointment_id',$request->appointment_id)->update(['appointment_status'=>4,'appointment_updated_on'=>date('Y-m-d H:i:s')]);

            return $this->sendResponse([],'Your appointment with '.$user_name.' is cancelled');
        }
    }

}
