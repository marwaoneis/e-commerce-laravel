<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_orders()
    {
        // Get All orders
        $orders = Order::all();
        return response()->json($orders);
    }

    public function add_order(Request $request)
    {
        $user_role = auth()->user()->user_role;
        // If user is a buyer
        if ($user_role == 2) {
            $user_id = ["user_id" => auth()->user()->user_id];
            $request->merge($user_id);
            $order = Order::create($request->all());
            return response()->json($order, 201);
        }
    }

    public function update_order(Request $request, $id)
    {
        $user_role = auth()->user()->user_role;
        if ($user_role == 2) { // If user is a seller
            $order = Order::find($id);
            if (!$order) {
                return response()->json([
                    "status" => "error",
                    "message" => "order not found"
                ]);
            }
            $order->update($request->all());
            return response()->json($order, 200);
        }
    }
    public function delete_order(Request $request, $id)
    {
        $user_role = auth()->user()->user_role;
        if ($user_role == 2) {
            $order = Order::find($id);
            if (!$order) {
                return response()->json([
                    "status" => "error",
                    "message" => "order not found"
                ]);
            }
            $order->delete();
            return response()->json(null, 204);
        }
    }
}
