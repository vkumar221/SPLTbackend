<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Category;

class UserCategoryController extends BaseController
{
    public function index(Request $request)
    {
        $categories = Category::where('category_status',1)->get();
        if(isset($categories))
        {
            foreach($categories as $key=> $category)
            {
                $cat[$key]['category_id'] = $category->category_id;
                $cat[$key]['category_image'] = asset(config('constants.admin_path').'uploads/category/'.$category->category_image);
                $cat[$key]['category_name'] = $category->category_name;
            }
            $result['categories'] = $cat;
            return $this->sendResponse($result,'Categories List.');
        }
        else
        {
            return $this->sendError("No Categories found", []);
        }

    }

}
