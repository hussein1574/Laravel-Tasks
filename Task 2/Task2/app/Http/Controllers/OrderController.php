<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatue;

class OrderController extends Controller
{
    public function makeOrder()
    {
        $order = Order::create([
            'user_id' => '1',
            'status' => '1',
            'total_cost' => 0
        ]);
        $orderItem = $order->orderItems()->create([
            'product_id' => '1',
            'qty' => 2,
            'price' => 100
        ]);
        return response()->json($order);
    }
    public function getOrdersAbove500()
    {
        $orders = Order::where('total_cost', '>', 500)->get();
        return response()->json($orders);
    }
    public function getUserOrders($id)
        {
            $userOrders = Order::where('user_id', $id)->get();
            if ($userOrders->isEmpty()) {
                return response()->json(['message' => 'User has no orders'], 404);
            }
            $ordersCount = $userOrders->count();
            $totalPrice = $userOrders->sum('total_cost');
            $ordersByState = $userOrders->groupBy('status')->map(function ($orders) {
                return [
                    'count' => $orders->count(),
                    'total_price' => $orders->sum('total_cost')
                ];
            });
            
            return response()->json([
                'orders_count' => $ordersCount,
                'total_price' => $totalPrice,
                'orders_by_state' => $ordersByState
            ]);
        }
}