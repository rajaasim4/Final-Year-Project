<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Carbon\Exceptions\EndLessPeriodException;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        $product = Product::with('Images')->find($request->id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found',
            ]);


        }

        if (Cart::count() > 0) {
            $carContent = Cart::content();
            $productAlreadyExist = false;
            foreach ($carContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }
            }

            if ($productAlreadyExist == false) {
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->Images->first())) ? $product->Images->first() : '']);

                $status = true;
                $message = $product->title . ' added in the cart';
            } else {
                $status = false;
                $message = $product->title . ' Already in the cart';
            }
        } else {
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->Images->first())) ? $product->Images->first() : '']);
            $status = true;
            $message = $product->title . ' is added to cart';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    public function cart()
    {
        $cartContent = Cart::content();
        // dd($cartContent);
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);
        if ($product->track_qty == "Yes") {
            if ($qty <= $product->qty) {
                Cart::update($rowId, $qty);
                $message = "Cart is updated Successfully";
                $status = false;
                session()->flash('success', $message);
            } else {
                $message = 'Request qty(' . $qty . ') not available in stock';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            Cart::update($rowId, $qty);
            $message = "Cart is updated Successfully";
            $status = true;
            session()->flash('success', $message);
        }

        Cart::update($rowId, $qty);
        $message = 'Cart is updated Successfully';

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function deleteItem(Request $request)
    {


        $itemInfo = Cart::get($request->rowId);
        if ($itemInfo == null) {
            $errorMessage = 'Item not found in the cart.';
            session()->flash('error', $errorMessage);
            return response()->json([
                'status' => false,
                'message' => $errorMessage,
            ]);
        }
        Cart::remove($request->rowId);

        $message = "Item remove from the cart";
        session()->flash('error', $message);
        return response()->json([
            'status' => true,
            'message' => $message,
        ]);

    }

    public function checkout()
    {
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }
        if (Auth::check() == false) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('account.login');
        }
        session()->forget('url.intended');
        return view('front.checkout');
    }

    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'appartment' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix the message',
                'errors' => $validator->errors(),
            ]);

        }
        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile,' => $request->mobile,
                'address,' => $request->address,
                'appartment' => $request->appartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,

            ]
        );
        if($request->payment_method == 'cod'){
            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(2,'.','');
            $grandTotal = $subTotal+$shipping;

            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total  = $grandTotal;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->appartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->notes = $request->notes;
            $order->save();

            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name=$item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total - $item->price*$item->qty;
                $orderItem->save();

            }
            session()->flash('success','You have successfully placed your order');
            Cart::destroy();
            return response()->json([
                'status' => true,
                'message' => 'Order Saved Successfully',
                'orderId' => $order->id,
                
            ]);

        }
        else{
            
        }
    }

    public function thankyou($id){
        return view('front.thanks',[
            'id'=>$id,
        ]);
    }
}
