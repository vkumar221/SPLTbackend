<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Page;
use App\Models\Setting;

class UserPageController extends BaseController
{
    public function terms(Request $request)
    {
        $page = Page::where('page_id',1)->first();
        if(isset($page))
        {
            $result['title'] = $page->page_title;
            $result['content'] = $page->page_content;
            return $this->sendResponse($result,'Terms and Conditions.');
        }
        else
        {
            return $this->sendResponse([],'No Content found');
        }

    }

    public function about(Request $request)
    {
        $page = Page::where('page_id',2)->first();
        if(isset($page))
        {
            $result['title'] = $page->page_title;
            $result['content'] = $page->page_content;
            return $this->sendResponse($result,'About us.');
        }
        else
        {
            return $this->sendResponse([],'No Content found');
        }

    }

    public function contact(Request $request)
    {
        $setting = Setting::where('setting_id',1)->first();
        if(isset($setting))
        {
            $result['email'] = $setting->setting_email;
            $result['phone'] = $setting->setting_phone;
            return $this->sendResponse($result,'Contact Info.');
        }
        else
        {
            return $this->sendResponse([],'No Content found');
        }

    }

}
