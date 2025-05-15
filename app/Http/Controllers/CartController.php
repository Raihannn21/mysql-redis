<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $cartKey = "cart:$userId";

        $cartItems = Redis::hgetall($cartKey); // ambil data keranjang (hash map)

        $products = [];
        $total = 0;

        foreach ($cartItems as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $product->quantity = $quantity;
                $product->subtotal = $product->price * $quantity;
                $total += $product->subtotal;
                $products[] = $product;
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $userId = Auth::id();
        $cartKey = "cart:$userId";

        $quantity = $request->input('quantity', 1);

        Redis::hincrby($cartKey, $product->id, $quantity);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function remove(Product $product)
    {
        $userId = Auth::id();
        $cartKey = "cart:$userId";

        Redis::hdel($cartKey, $product->id);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}

