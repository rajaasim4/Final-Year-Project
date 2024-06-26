<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){
        return view('front.account.login');
    }

    public function register()
    {
        return view('front.account.register');
    }


    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required',    
            'password'=>'required|min:5|confirmed',
        ]);

        if($validator->passes()){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success','You have been registered successfully');

            return response()->json(['status'=>true,'message'=>'You have been registered successfully']);

            
        }
        else{
            return response()->json(['status'=>false,'errors'=>$validator->errors()]);
        }
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);
        if($validator->passes()){
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password],$request->get('remember')))
            {
                if(session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');
            }
            else{
                return redirect()->route('account.login')->with('error','Invalid Credentials');
            }
        }else{
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->email);
        }
    }

    public function profile(){
        return view('front.account.profile');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login')->with('success','You have Successfully logged Out.');
    }

    public function order(){
        $user = Auth::user();
        $orders = Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();
        $data['orders'] = $orders;
        return view('front.account.order',$data);
    }

    public function orderDetail($id){
        $data = [];
        $user = Auth::user();
        $order = Order::where('user_id',$user->id)->where('id',$id)->first();
        $orderItems = OrderItem::where('order_id',$id)->get();
        $orderItemsCount = OrderItem::where('order_id',$id)->count();

        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        $data['orderItemsCount'] = $orderItemsCount;
        return view('front.account.order-detail',$data);
    }
}
