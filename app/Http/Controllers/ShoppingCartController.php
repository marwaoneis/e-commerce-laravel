<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartProducts;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_shopping_cart()
    {
        $user_role = auth()->user()->user_role;
        if ($user_role == 2) {
            $user_id = auth()->user()->id;
            $shoppingcartProducts = ShoppingCartProducts::where('user_id', $user_id)->get('product_id');
            $Products = [];
            foreach ($shoppingcartProducts as $product) {
                $Products[] = Product::find($product->product_id)->product_name;
            }
            return response()->json($Products, 201);
        }
    }
    public function add_shopping_cart(Request $request)
    {
        $user_role = auth()->user()->user_role;
        if ($user_role == 2) {
            $user_id = ["user_id" => auth()->user()->id];
            $request->merge($user_id);

            $products = $request->products;
            // Make a new Cart
            $shopping_cart = ShoppingCart::create($request->all());

            $shopping_cart_product = [];
            foreach ($products as $product) {
                if (isset($product["product_id"]) && isset($product["quantity"])) {
                    $shopping_cart_product[] = ShoppingCartProducts::create([
                        "user_id" => $shopping_cart->user_id,
                        "cart_id" => $shopping_cart->cart_id,
                        "product_id" => $product["product_id"],
                        "quantity" => $product["quantity"]
                    ]);
                }
            }
            return response()->json($shopping_cart_product, 201);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "You are not authorized to perform this action"
            ]);
        }
    }
    public function delete_shopping_cart(Request $request)
    {
        $user_role = auth()->user()->user_role;
        if ($user_role == 2) {
            $user_id = auth()->user()->id;
            $shopping_cart = ShoppingCart::where('user_id', $user_id)->first();
            $shopping_cart_products = ShoppingCartProducts::where('cart_id', $shopping_cart->cart_id)->get();
            foreach ($shopping_cart_products as $shopping_cart) {
                $shopping_cart_product->delete();
            }
            $shopping_cart->delete();
            return response()->json([
                "status" => "success",
                "message" => "Shopping cart deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "You are not authorized to perform this action"
            ]);
        }
    }
}