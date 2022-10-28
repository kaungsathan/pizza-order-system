<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct to order list page
    public function listPage() {
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','orders.user_id','users.id')
                ->when(request('key'),function($query){
                    $query->orwhere('orders.order_code','like','%'. request('key') .'%')
                        ->orWhere('users.name', 'like', '%' . request('key') . '%');
                })
                ->orderBy('created_at','desc')
                ->get();
        // $order->appends(request()->all());
        return view('admin.order.list',compact('order'));
    }
    // sorting order status with ajax
    public function ajaxStatus(Request $request) {

        $order = Order::select('orders.*', 'users.name as user_name')
                    ->leftJoin('users', 'orders.user_id', 'users.id')
                    ->when(request('key'), function ($query) {
                        $query->orwhere('orders.order_code', 'like', '%' . request('key') . '%')
                            ->orWhere('users.name', 'like', '%' . request('key') . '%');
                    })
                    ->orderBy('created_at', 'desc');

        if($request->status == null) {
            $order = $order->get();
        }else {
            $order = $order->where('orders.status', $request->status)->get();
        };

        return response()->json($order,200);
    }

    // order status changing
    public function statusChange(Request $request) {
        Order::where('id',$request->orderId)->update([
            'status' => $request->status
        ]);
    }

    // direct to order detial page
    public function detailPage($orderCode) {

        $total = Order::where('order_code',$orderCode)->first();

        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.name as product_name','products.image as product_image')
        ->leftJoin('users','order_lists.user_id','users.id')
        ->leftJoin('products','order_lists.product_id','products.id')
        ->where('order_lists.order_code',$orderCode)
        ->get();


        return view('admin.order.orderDetail',compact('orderList','total'));
    }
}
