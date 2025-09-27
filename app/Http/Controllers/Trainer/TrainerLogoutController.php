<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TrainerLogoutController extends Controller
{
    public function index(Request $request)
    {
        Auth::guard('trainer')->logout();

        return redirect('trainer');
    }
}
