<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class VendorLogoutController extends Controller
{
    public function index(Request $request)
    {
        Auth::logout();

        return redirect('vendor');
    }
}
