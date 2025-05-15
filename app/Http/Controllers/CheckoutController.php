<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Tampilkan halaman checkout
        $userId = Auth::id();
        $cartKey = "cart:$userId";
        $cartItems = Redis::hgetall($cartKey);

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
        return view('checkout.index', compact('products', 'total'));
    }

    public function process(Request $request)
    {
        $userId = Auth::id();
        $cartKey = "cart:$userId";
        $cartItems = Redis::hgetall($cartKey);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($cartItems as $productId => $quantity) {
                $product = Product::find($productId);
                if (!$product || $product->stock < $quantity) {
                    return redirect()->route('cart.index')->with('error', 'Stok produk tidak cukup.');
                }
                $total += $product->price * $quantity;
            }

            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $productId => $quantity) {
                $product = Product::find($productId);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
                // Kurangi stok
                $product->stock -= $quantity;
                $product->save();
            }

            // Kosongkan keranjang Redis
            Redis::del($cartKey);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Order berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat checkout.');
        }
    }
}
