<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function confirmation(Order $order)
    {
        // Pastikan order milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load relasi order details dan produk
        $order->load('orderDetails.product');

        return view('order.confirmation', compact('order'));
    }
}
