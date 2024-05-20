<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $totalOrders = Order::where('status','delievered')->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role',1)->count();
        $totalRevenue = Order::where('status','delievered')->sum('grand_total');
        $data['totalRevenue'] = $totalRevenue;
        $data['totalCustomers'] = $totalCustomers;
        $data['totalProducts'] = $totalProducts;
        $data['totalOrders'] = $totalOrders;
        return view('admin.dashboard',$data);
        // $admin = Auth::guard('admin')->user();
        // echo "Welcome".$admin->name.'<a href="'.route('admin.logout').'" >Logout</a>';
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
