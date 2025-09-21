<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Carbon\Carbon;
use App\Models\User;
use Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'dashboard';
        return view('admin.dashboard.dashboard',$data);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }

}
