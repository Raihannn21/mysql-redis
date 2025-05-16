<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $cartKey = "cart:$userId";
        $cartItems = Redis::hgetall($cartKey);

        $products = [];
        $total = 0;

        if ($cartItems) {
            // Ambil semua produk sekaligus supaya tidak query berulang
            $productIds = array_keys($cartItems);
            $dbProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($cartItems as $productId => $quantity) {
                if (isset($dbProducts[$productId])) {
                    $product = $dbProducts[$productId];
                    $product->quantity = $quantity;
                    $product->subtotal = $product->price * $quantity;
                    $total += $product->subtotal;
                    $products[] = $product;
                }
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
            return redirect()->route('checkout.index')->with('error', 'Keranjang kosong.');
        }

        $request->validate([
            'payment_method' => 'required|in:transfer,kartu',
        ]);

        DB::beginTransaction();

        try {
            // Ambil produk dari DB sekaligus
            $productIds = array_keys($cartItems);
            $dbProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');

            $total = 0;

            // Cek stok dan hitung total
            foreach ($cartItems as $productId => $quantity) {
                if (!isset($dbProducts[$productId])) {
                    throw new \Exception('Produk tidak ditemukan.');
                }
                $product = $dbProducts[$productId];
                if ($product->stock < $quantity) {
                    throw new \Exception("Stok produk '{$product->name}' tidak cukup.");
                }
                $total += $product->price * $quantity;
            }

            // Buat order dengan payment_method
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            // Buat detail order dan kurangi stok
            foreach ($cartItems as $productId => $quantity) {
                $product = $dbProducts[$productId];
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                $product->stock -= $quantity;
                $product->save();
            }

            // Kosongkan cart Redis
            Redis::del($cartKey);

            DB::commit();

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Order berhasil dibuat! Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Bisa disesuaikan untuk debugging:
            // return redirect()->route('checkout.index')->with('error', $e->getMessage());
            
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }
}
