<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $products = Product::where('is_featured','Yes')->where('status',1)->get();
        $latestProducts = Product::where('status',1)->orderBy('id','DESC')->take(8)->get();
        $data['featuredProducts'] = $products;
        $data['latestProducts'] = $latestProducts;
        return view('front.home',$data);
    }
}
