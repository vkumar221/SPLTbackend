<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLogoutController extends Controller
{
    public function index(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect('admin');
    }
}
