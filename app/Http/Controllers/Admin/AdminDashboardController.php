<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['set'] = 'dashboard';
        $order_discount = Order::sum('order_discount');
        $order_total = Order::sum('order_total');
        $data['sales'] = $order_total - $order_discount;
        $data['orders'] = Order::count();
        $data['product'] = Product::where('product_status',1)->count();
        return view('admin.dashboard.dashboard',$data);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }

}
