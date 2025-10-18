<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Carbon\Carbon;
use App\Models\User;
use Auth;

class VendorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'dashboard';
        return view('vendor.dashboard.dashboard',$data);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('vendor.login');
    }

}
