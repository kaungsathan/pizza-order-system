<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //get pizza list
    public function pizzaList(Request $request) {
        // logger($request->status);
        if($request->status == 'asc') {
            $data = Product::orderBy('created_at','asc')->get();
        }
        else if($request->status == 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        }
        else {
            $data = Product::get();
        }

        return $data;
    }

    // add to cart
    public function addToCart(Request $request) {
        $data = $this->getData($request);
        Cart::create($data);
        $message = [
            'status' => 'success',
            'process' => 'addToCart'
        ];
        return response()->json($message,200);
    }

    // send data to orderlist
    public function order(Request $request) {

        $total = 0;
        foreach ($request->all() as $item) {
            $data = OrderList::create([
                'user_id' => $item['userId'],
                'product_id' => $item['productId'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['orderCode']
            ]);

            $total += $data->total;
        }
        Cart::where('user_id',Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total+3000
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'order complete'
        ],200);
    }

    // clear cart button
    public function clearCart() {
        Cart::where('user_id',Auth::user()->id)->delete();
    }

    // product clear
    public function productClear(Request $request) {
        Cart::where('user_id',Auth::user()->id)->where('id',$request->cartId)->delete();
    }

    // product view count
    public function productView(Request $request) {
        $product = Product::where('id',$request->productId)->first();

        $viewCount = [
            'view_count' => $product->view_count + 1
        ];

        Product::where('id', $request->productId)->update($viewCount);
    }

    // private function
    // addToCart data to array format
    private function getData($request) {
        return [
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->qty
        ];
    }
}
