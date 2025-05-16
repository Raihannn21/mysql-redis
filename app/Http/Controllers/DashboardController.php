<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get(); // ambil semua produk
        return view('dashboard', compact('products'));
    }
}
