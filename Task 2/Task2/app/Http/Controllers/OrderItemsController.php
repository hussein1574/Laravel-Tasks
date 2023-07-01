<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderItemsController extends Controller
{
    public function getTheMost3Products()
    {
        $mostSoldItems = DB::table('order_items')
                        ->select('product_id', DB::raw('SUM(qty) as total_quantity'), DB::raw('SUM(price) * SUM(qty)  as total_price'), DB::raw('COUNT(*) as total_orders'))
                        ->groupBy('product_id')
                        ->orderByDesc('total_quantity')
                        ->limit(3)
                        ->get();

        return response()->json($mostSoldItems);
    }
}
        