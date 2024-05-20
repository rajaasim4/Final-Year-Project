<?php
use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
    function getCategories(){
        return Category::latest()->with('sub_category')->get();
    }
    function getProductImage($productId)
    {
        Product::where('id',$productId)->first();
    }

    function orderEmail($orderId){
        $order = Order::where('id',$orderId)->with('item')->first();
        $mailData = [
            'subject'=>'Thanks! Enjoy Meal.',
            'order'=>$order,
        ];
        Mail::to($order->email)->send(new OrderEmail($mailData));
    }
?>