<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\TrainerCertificate;

class UserCertificateController extends BaseController
{
    public function index(Request $request)
    {
        $certificates = TrainerCertificate::where('certificate_added_by',Auth::user()->id)->get();
        if($certificates->count() > 0)
        {
            foreach($certificates as $key=> $certificate)
            {
                $cert[$key]['certificate_id'] = $certificate->certificate_id;
                $cert[$key]['certificate_title'] = $certificate->certificate_title;
                $cert[$key]['certificate_image'] = asset(config('constants.trainer_path').'uploads/certificate/'.$certificate->certificate_image);
            }
            $result['certificates'] = $cert;
            return $this->sendResponse($result,'Certificates List.');
        }
        else
        {
            return $this->sendError("No Certificates found", []);
        }

    }

    public function trainer_certificate(Request $request)
    {
        $rules = ['trainer_id' => 'required',];

        $messages = ['trainer_id.required'=>'Please provide trainer id',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $certificates = TrainerCertificate::where(['certificate_added_by'=>$request->trainer_id,'certificate_status'=>1,'certificate_trash'=>0])->get();
        if($certificates->count() > 0)
        {
            foreach($certificates as $key=> $certificate)
            {
                $cert[$key]['certificate_id'] = $certificate->certificate_id;
                $cert[$key]['certificate_title'] = $certificate->certificate_title;
                $cert[$key]['certificate_image'] = asset(config('constants.trainer_path').'uploads/certificate/'.$certificate->certificate_image);
            }
            $result['certificates'] = $cert;
            return $this->sendResponse($result,'Certificates List.');
        }
        else
        {
            return $this->sendError("No Certificates found", []);
        }

    }

    public function add_certificate(Request $request)
    {
        $rules = ['certificate_title' => 'required',
                'certificate_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',];

        $messages = ['certificate_title.required'=>'Please provide Title',
                    'certificate_image.required'=>'Please provide Image',];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails())
        {
            return $this->sendError($validator->errors(), ['error'=>'Validation Errors']);
        }

        $ins['certificate_title']              = $request->certificate_title;
        $ins['certificate_status']             = 1;
        $ins['certificate_added_by']           = Auth::user()->id;
        $ins['certificate_added_on']           = date('Y-m-d H:i:s');
        $ins['certificate_updated_by']         = Auth::user()->id;
        $ins['certificate_updated_on']         = date('Y-m-d H:i:s');

        if($request->hasFile('certificate_image'))
        {
            $certificate_image = $request->certificate_image->store('assets/trainer/uploads/certificate');

            $certificate_image = explode('/',$certificate_image);
            $certificate_image = end($certificate_image);
            $ins['certificate_image'] = $certificate_image;
        }

        $certificate_id = TrainerCertificate::insertGetId($ins);

        if($certificate_id)
        {
            return $this->sendResponse([],'Certificate Added.');
        }
    }

}
